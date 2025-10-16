# Stage 1: build TypeScript
FROM node:20-bookworm-slim AS build
WORKDIR /usr/src/app
COPY package*.json tsconfig.json ./
RUN npm ci
COPY src ./src
COPY config ./config
COPY public ./public
RUN npm run build

# Stage 2: runtime
FROM node:20-bookworm-slim
WORKDIR /usr/src/app

# install ffmpeg (karena node image ini Debian-based)
RUN apt-get update && apt-get install -y --no-install-recommends ffmpeg \
    && rm -rf /var/lib/apt/lists/*

COPY --from=build /usr/src/app/dist ./dist
COPY --from=build /usr/src/app/config ./config
COPY --from=build /usr/src/app/public ./public
COPY package*.json .env ./

# install production dependencies
RUN npm ci --only=production

ENV HLS_DIR=/usr/src/app/hls
RUN mkdir -p /usr/src/app/hls
EXPOSE 3000

CMD ["node", "dist/index.js"]
