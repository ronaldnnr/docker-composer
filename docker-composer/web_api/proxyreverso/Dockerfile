FROM nginx:1.18-alpine
MAINTAINER Ronald Silva <ronaldnnr@gmail.com>

RUN	mkdir -p /etc/nginx/includes/
COPY	./proxyreverso/arquivos/default.conf /etc/nginx/conf.d/
COPY	./proxyreverso/arquivos/nginx.conf /etc/nginx/
COPY	./proxyreverso/arquivos/proxy.conf /etc/nginx/includes/
