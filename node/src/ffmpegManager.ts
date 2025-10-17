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

    if(fs.existsSync(cameraDir)) {
      this.cleanupCameraFiles(id);
    }
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
      "-hls_time", "3",
      "-hls_list_size", "10",
      "-reconnect", "1",
      "-reconnect_at_eof", "1",
      "-reconnect_streamed", "1",
      "-reconnect_delay_max", "2",
      "-hls_flags", "delete_segments+program_date_time+omit_endlist",
      "-strftime", "1",
      "-hls_segment_filename", path.join(cameraDir, "seg-%Y%m%d-%H%M%S.ts"),
      path.join(cameraDir, "index.m3u8"),
    ];

    console.log(`Starting ffmpeg for ${id}: ffmpeg ${args.join(" ")}`);
    const p = spawn("ffmpeg", args, { stdio: ["ignore", "pipe", "pipe"] });
    this.procs[id] = p;

    p.stdout.on("data", d => console.log(`[ffmpeg ${id} stdout] ${d}`));
    p.stderr.on("data", d => console.log(`[ffmpeg ${id} stderr] ${d}`));

    p.on("exit", (code, sig) => {
      console.log(`ffmpeg for ${id} exited code=${code} sig=${sig}`);
      this.procs[id] = null;
    });

    p.on("error", (error) => {
      console.error(`ffmpeg for ${id} process error:`, error);
      this.procs[id] = null;
    });

    p.on('close', (code, sig) => {
      if (code !== 0) {
        console.log(`ffmpeg close process exited with code=${code} sig=${sig}`);
      }
    });
  }

  async cleanupCameraFiles(cameraId: string) {
    const cameraDir = path.join(this.baseHlsDir, `cam_${cameraId}`);

    try {
      if (fs.existsSync(cameraDir)) {
        const files = fs.readdirSync(cameraDir);

        for (const file of files) {
          if (file.endsWith('.ts') || file.endsWith('.m3u8')) {
            const filePath = path.join(cameraDir, file);
            fs.unlinkSync(filePath);
          }
        }

        console.log(`Cleaned up all files for camera ${cameraId}`);
      }
    } catch (error) {
      console.error(`Error cleaning up camera ${cameraId}:`, error);
    }
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
