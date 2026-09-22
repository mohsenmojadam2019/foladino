#!/usr/bin/env bash
set -euo pipefail
mkdir -p storage/backups
stamp=$(date +%Y%m%d_%H%M%S)
mysqldump --single-transaction --host="${DB_HOST}" --port="${DB_PORT:-3306}" --user="${DB_USERNAME}" --password="${DB_PASSWORD}" "${DB_DATABASE}" | gzip > "storage/backups/${DB_DATABASE}_${stamp}.sql.gz"
find storage/backups -type f -name '*.sql.gz' -mtime +14 -delete
