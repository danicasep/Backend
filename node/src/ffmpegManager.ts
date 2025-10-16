import { spawn, ChildProcess } from "child_process";
import fs from "fs";
import path from "path";
import { CameraConfig } from "./types";

type ProcMap = Record<string, ChildProcess | null>;;

export class FfmpegManager {
  baseHlsDir: string;
  procs: ProcMap = {};

  constructor(baseHlsDir = "../hls") {
    this.baseHlsDir = baseHlsDir;
    if (!fs.existsSync(this.baseHlsDir)) fs.mkdirSync(this.baseHlsDir, { recursive: true });
  }

  startCamera(camera: CameraConfig) {
    const id = camera.id;
    const cameraDir = camera.hlsFolder ? camera.hlsFolder : path.join(this.baseHlsDir, id);
    if (!fs.existsSync(cameraDir)) fs.mkdirSync(cameraDir, { recursive: true });

    // jika sudah jalan, jangan start ulang
    if (this.procs[id]) {
      console.log(`ffmpeg for ${id} already running`);
      return;
    }

    // contoh opsi ffmpeg untuk low-latency HLS
    const args = [
      "-rtsp_transport", "tcp",
      "-i", camera.rtspUrl,
      "-c:v", "copy",
      "-c:a", "aac",
      "-f", "hls",
      "-hls_time", "10",
      "-hls_list_size", "20",
      "-reconnect", "1",
      "-reconnect_streamed", "1",
      "-reconnect_delay_max", "5",
      "-hls_flags", "delete_segments+program_date_time+omit_endlist",
      "-strftime", "1",
      "-hls_segment_filename", path.join(cameraDir, "seg-%Y%m%d-%H%M%S.ts"),
      path.join(cameraDir, "index.m3u8"),
    ];

    console.log(`Starting ffmpeg for ${id}: ffmpeg ${args.join(" ")}`);
    const p = spawn("ffmpeg", args, { stdio: ["ignore", "pipe", "pipe"] });
    this.procs[id] = p;

    p.stdout.on("data", d => console.log(`[ffmpeg ${id} stdout] ${d}`));
    // p.stderr.on("data", d => console.log(`[ffmpeg ${id} stderr] ${d}`));

    p.on("exit", (code, sig) => {
      console.log(`ffmpeg for ${id} exited code=${code} sig=${sig}`);
      this.procs[id] = null;
      // opsi: restart otomatis setelah delay
      setTimeout(() => {
        if (!this.procs[id]) this.startCamera(camera);
      }, 3000);
    });
  }

  stopCamera(id: string) {
    const p = this.procs[id];
    if (!p) return;
    p.kill("SIGINT");
    this.procs[id] = null;
  }

  startAll(cameras: CameraConfig[]) {
    for (const c of cameras) this.startCamera(c);
  }

  stopAll() {
    for (const id in this.procs) this.stopCamera(id);
  }
}
