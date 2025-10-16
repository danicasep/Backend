export type CameraConfig = {
  id: string;           // unique id e.g. cam1
  rtspUrl: string;      // rtsp://user:pass@ip/stream
  hlsFolder?: string;   // optional override
  name: string;
};