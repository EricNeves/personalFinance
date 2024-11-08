FROM node:21-alpine

WORKDIR /app

COPY . .

RUN npm install -g pnpm
RUN npm install -g @angular/cli
RUN pnpm install

EXPOSE 4200

CMD ["pnpm", "start", "--host", "0.0.0.0"]
