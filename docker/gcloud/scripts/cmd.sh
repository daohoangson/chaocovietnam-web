#!/bin/sh

dev_appserver.py \
  --admin_host="$GCLOUD_CONTAINER_IP" \
  --host="$GCLOUD_CONTAINER_IP" \
  --php_executable_path=/usr/bin/php-cgi7 \
  app.yaml
