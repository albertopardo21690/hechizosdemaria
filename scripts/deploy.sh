#!/bin/bash
# Deploy de hechizosdemaria desde GitHub Actions.
# Solo se ejecuta via SSH con la deploy key dedicada (configurada con command= en authorized_keys).
set -euo pipefail
cd /var/www/hechizosdemaria

LOG=/var/www/hechizosdemaria/storage/logs/deploy.log
mkdir -p "$(dirname "$LOG")"
exec > >(tee -a "$LOG") 2>&1
echo
echo "===== DEPLOY $(date -Iseconds) ====="

git fetch origin main
git reset --hard origin/main

# Permisos correctos para Laravel
chown -R www-data:www-data storage bootstrap/cache

# PHP deps
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Frontend (Vite)
if [ -f package.json ]; then
    npm ci --no-audit --no-fund
    npm run build
fi

# Laravel
sudo -u www-data php artisan migrate --force --no-interaction
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan storage:link 2>/dev/null || true

# Reload php-fpm para aplicar opcache
systemctl reload php8.3-fpm

# Notificacion Telegram
COMMIT=$(git log -1 --pretty=format:'%h - %s')
if [ -f /root/assistant/scripts/notifications.py ]; then
    python3 -c "
import sys; sys.path.insert(0,'/root/assistant/scripts')
from notifications import send_telegram
send_telegram('Deploy hechizosdemaria OK: $COMMIT')
" || true
fi

echo "===== DEPLOY OK $(date -Iseconds) ====="
