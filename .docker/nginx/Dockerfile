FROM nginx:stable-alpine

# Install packages
RUN apk --update --no-cache add openssl

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel
RUN sed -i "s/user  nginx/user laravel/g" /etc/nginx/nginx.conf

ADD ./default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html
