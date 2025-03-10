FROM golang

RUN mkdir -p /var/www/go_src
ADD ./go_src/ /var/www/go_src
