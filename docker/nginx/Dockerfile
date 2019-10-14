FROM debian:jessie
MAINTAINER Ezequiel Schneider da Silva <ezequielrs@gmail.com>

RUN apt-get update && apt-get install -y nginx

RUN usermod -u 1000 www-data
CMD ["nginx"]

EXPOSE 80
EXPOSE 443