import express from "express";
import path from "path";
import fs from "fs";
import cors from "cors";
import { FfmpegManager } from "./ffmpegManager";
import { CameraConfig } from "./types";
import { Database } from "./database/database";
require('dotenv').config();

const app = express();
const PORT = process.env.PORT ? parseInt(process.env.PORT) : 3333;
const HLS_DIR = "./hls";
const CAMERA_CONFIG = "./config/camera.json";

app.use(cors({ 
  origin: "*",
  allowedHeaders: ["Content-Type", "Range"],
  exposedHeaders: ["Content-Length", "Content-Range"]
}));

let cameras: CameraConfig[] = [];

// baca config kamera
try {
  const raw = fs.readFileSync(CAMERA_CONFIG, "utf-8");
  cameras = JSON.parse(raw) as CameraConfig[];
} catch (err) {
  console.error("Failed to load camera config:", err);
  process.exit(1);
}

const manager = new FfmpegManager(HLS_DIR);

initCameras();

// inisialisasi kamera dari database
async function initCameras(isStopCameras = false) {
  const database = new Database();
  try {
    const rows = await database.select('SELECT id, name, rtspUrl FROM cctv WHERE deleted_at IS NULL AND isActive = 1');
    cameras = rows.map(row => ({
      id: row.id,
      rtspUrl: row.rtspUrl,
      name: row.name,
      hlsFolder: `${HLS_DIR}/cam_${row.id}`,
    }));
    const manager = new FfmpegManager(HLS_DIR);
    manager.logConsole(`Loaded ${cameras.length} cameras from database.`);

    if (isStopCameras) manager.stopAll();
    manager.startAll(cameras);
  } catch (err) {
    console.error('Failed to load cameras from database:', err);
  }
}

// static serve HLS folder and public
app.use("/hls", express.static(HLS_DIR, {
  setHeaders: (res, filePath) => {
    if (filePath.endsWith(".m3u8")) {
      res.setHeader("Content-Type", "application/vnd.apple.mpegurl");
    } else if (filePath.endsWith(".ts")) {
      res.setHeader("Content-Type", "video/mp2t");
    }
  }
}));
app.use("/public", express.static(path.join(__dirname, "..", "public")));

// endpoint untuk menambah/ubah kamera runtime (opsional)
app.use(express.json());
app.post("/api/connect", (req, res) => {
  const { token } = req.body;
  if (token !== process.env.TOKEN) {
    return res.status(403).json({ error: "Forbidden" });
  }

  res.json({ ok: true });
});

app.get("/api/update-camera/stop/:id", async (req, res) => {
  const { id } = req.params;
  const { token } = req.headers;
  if (token !== process.env.TOKEN) {
    return res.status(403).json({ error: "Forbidden" });
  }

  manager.stopCamera(id);
  res.json({ ok: true });
});

app.get("/api/update-camera/play/:id", async (req, res) => {
  const { id } = req.params;
  const { token } = req.headers;
  if (token !== process.env.TOKEN) {
    return res.status(403).json({ error: "Forbidden" });
  }

  const database = new Database();
  const row = await database.select('SELECT id, name, rtspUrl FROM cctv WHERE deleted_at IS NULL AND id = ?', [id]);
  if (row.length === 0) {
    return res.status(404).json({ error: "Camera not found" });
  }
  const camera: CameraConfig = {
    id: row[0].id,
    rtspUrl: row[0].rtspUrl,
    name: row[0].name,
    hlsFolder: `${HLS_DIR}/cam_${row[0].id}`,
  };
  manager.startCamera(camera);
  res.json({ ok: true });
});

app.get("/api/camera/restart", async (req, res) => {
  const { token } = req.headers;
  if (token !== process.env.TOKEN) {
    return res.status(403).json({ error: "Forbidden" });
  }
  await initCameras(true);
  res.json({ ok: true });
});

app.get("/", (_, res) => {
  res.sendFile(path.join(__dirname, "..", "public", "viewer.html"));
});

process.on("SIGINT", () => {
  console.log("Shutting down...");
  manager.stopAll();
  process.exit(0);
});

app.listen(PORT, () => {
  console.log(`Server listening on http://0.0.0.0:${PORT}`);
  console.log(`Viewer: http://0.0.0.0:${PORT}/`);
});

setInterval(async () => {
  const database = new Database();
  const cameras = await database.select('SELECT id FROM cctv WHERE deleted_at IS NULL AND isActive = 1 AND cctvStatus = 0');

  cameras.map((cam: any) => {
    console.log(`Keeping alive camera ID ${cam.id}`);
    const camera: CameraConfig = {
      id: cam.id,
      rtspUrl: cam.rtspUrl,
      name: cam.name,
      hlsFolder: `${HLS_DIR}/cam_${cam.id}`,
    };
    manager.stopCamera(cam.id);
    manager.startCamera(camera);
  });
}, 5 * 60 * 1000); // keep alive every 5 minutes