import { spawn, ChildProcess } from "child_process";
import fs from "fs";
import path from "path";
import { CameraConfig } from "./types";
import { Database } from "./database/database";

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
    const database = new Database();
    if (fs.existsSync(cameraDir)) {
      this.cleanupCameraFiles(id);
    }
    if (!fs.existsSync(cameraDir)) fs.mkdirSync(cameraDir, { recursive: true });

    // jika sudah jalan, jangan start ulang
    if (this.procs[id]) {
      this.logConsole(`ffmpeg for ${id} already running`);
      return;
    }

    // contoh opsi ffmpeg untuk low-latency HLS
    const args = [
      "-y",
      "-nostdin",
      "-loglevel", "error",
      "-user_agent", "VLC/3.0.0",
      "-rtsp_transport", "tcp",
      "-timeout", "30000000",
      "-fflags", "+genpts+flush_packets+discardcorrupt",
      "-avoid_negative_ts", "make_zero",
      "-thread_queue_size", "512", // Thread queue size
      "-analyzeduration", "3000000", // 3 second analyze
      "-probesize", "1000000", // 1MB probe size
      "-max_delay", "500000", // No delay
      "-rtbufsize", "100M", // Increase realtime buffer
      "-i", camera.rtspUrl,
      "-c:v", "copy",
      "-tag:v", "hvc1",
      "-an",
      "-f", "hls",
      "-hls_time", "10",
      "-hls_list_size", "10",
      "-hls_segment_type", "fmp4",
      "-reconnect", "1",
      "-reconnect_at_eof", "1",
      "-reconnect_streamed", "1",
      "-reconnect_delay_max", "25",
      "-hls_flags", "delete_segments+program_date_time+omit_endlist",
      "-strftime", "1",
      "-hls_segment_filename", path.join(cameraDir, `seg-%Y%m%d-%H%M%S.m4s`),
      "-use_wallclock_as_timestamps", "0", // Disable wallclock
      "-max_muxing_queue_size", "2048", // Increased queue size
      "-muxdelay", "0", // No mux delay
      "-muxpreload", "0", // No preload
      path.join(cameraDir, "index.m3u8"),
    ];
    this.logConsole(`Camera dir ${cameraDir} is exists: ${fs.existsSync(cameraDir)}`);
    this.logConsole("Current working directory:" + process.cwd());

    database.updateCctvStatus(id, true).catch(err => {
      this.logConsole(`Failed to update CCTV status for ${id}: ${err}`);
    });

    this.logConsole(`Starting ffmpeg for ${id}: ffmpeg ${args.join(" ")}`);
    const p = spawn("ffmpeg", args, { stdio: ["ignore", "pipe", "pipe"] });
    this.procs[id] = p;

    p.stdout.on("data", d => console.log(`[ffmpeg ${id} stdout] ${d}`));
    // p.stderr.on("data", d => console.log(`[ffmpeg ${id} stderr] ${d}`));

    p.on("exit", (code, sig) => {
      this.logConsole(`ffmpeg for ${id} exited code=${code} sig=${sig}`);
      this.procs[id] = null;
    });

    p.on("error", (error) => {
      this.logConsole(`ffmpeg for ${id} process error: ${error}`);
      this.procs[id] = null;
      database.updateCctvStatus(id, false).catch(err => {
        this.logConsole(`Failed to update CCTV status for ${id}: ${err}`);
      });
    });

    p.on('close', (code, sig) => {
      this.logConsole(`ffmpeg close process exited with code=${code} sig=${sig}`);
      database.updateCctvStatus(id, false).catch(err => {
        this.logConsole(`Failed to update CCTV status for ${id}: ${err}`);
      });
    });
  }

  async cleanupCameraFiles(cameraId: string) {
    const cameraDir = path.join(this.baseHlsDir, `cam_${cameraId}`);

    try {
      if (fs.existsSync(cameraDir)) {
        const files = fs.readdirSync(cameraDir);

        for (const file of files) {
          if (file.endsWith('.ts') || file.endsWith('.m3u8') || file.endsWith('.m4s')) {
            const filePath = path.join(cameraDir, file);
            fs.unlinkSync(filePath);
          }
        }

        this.logConsole(`Cleaned up all files for camera ${cameraId}`);
      }
    } catch (error) {
      this.logConsole(`Error cleaning up camera ${cameraId}: ${error}`);
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

  logConsole(text: string) {
    console.log(`[${new Date().toISOString()}]: ${text}`);
  }
}
