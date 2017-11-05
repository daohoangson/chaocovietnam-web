#!/bin/sh

set -- dev_appserver.py \
  --admin_host="$GCLOUD_CONTAINER_IP" \
  --default_gcs_bucket_name="dev_bucket" \
  --host="$GCLOUD_CONTAINER_IP" \
  --php_executable_path=/usr/bin/php-cgi7 \
  --smtp_host=smtp.mailtrap.io \
  --smtp_password="$GCLOUD_SMTP_PASSWORD" \
  --smtp_port=25 \
  --smtp_user="$GCLOUD_SMTP_USER" \
  --storage_path=/root/.config/storage \
  app.yaml

echo "Executing $@..."
exec "$@"
