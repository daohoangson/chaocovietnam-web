FROM google/cloud-sdk:178.0.0-alpine

RUN gcloud components install app-engine-php

RUN apk add --no-cache php7 php7-bcmath php7-cgi php7-session

RUN curl https://bin.equinox.io/c/dhgbqpS8Bvy/minify-stable-linux-amd64.tgz -o/tmp/minify.tgz; \
  tar -xf /tmp/minify.tgz -C /usr/local/bin

VOLUME /var/www/html
WORKDIR /var/www/html

EXPOSE 8000 8080

CMD ["/var/www/html/docker/gcloud/scripts/cmd.sh"]
