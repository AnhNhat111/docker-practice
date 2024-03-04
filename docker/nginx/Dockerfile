FROM nginx:1.15-alpine

RUN apk add --no-cache curl

ARG USER_ID
ARG GROUP_ID

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
deluser nginx &&\
if getent group nginx ; then delgroup nginx; fi &&\
addgroup -g ${GROUP_ID} -S nginx; \
adduser -D -u ${USER_ID} -S -G nginx nginx \
;fi

COPY ./snippets /etc/nginx/snippets
COPY ./conf.d /etc/nginx/conf.d
COPY ./ssl/server.crt /etc/ssl/certs/server.crt
COPY ./ssl/server.key /etc/ssl/private/server.key

WORKDIR /src

HEALTHCHECK --interval=30s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1/health || exit 1

EXPOSE 80
EXPOSE 443
