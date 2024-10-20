FROM nginx:alpine

RUN apk add bash

COPY . /var/www/html

RUN rm /etc/nginx/conf.d/default.conf

COPY ./nginx/nginx.conf /etc/nginx/conf.d/nginx.conf