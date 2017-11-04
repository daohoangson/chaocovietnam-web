FROM google/cloud-sdk:178.0.0-alpine

RUN gcloud components install app-engine-php

RUN apk add --no-cache php7 php7-bcmath php7-cgi php7-session

VOLUME /var/www/html
WORKDIR /var/www/html

EXPOSE 8000 8080

CMD ["/var/www/html/docker/gcloud/scripts/cmd.sh"]
