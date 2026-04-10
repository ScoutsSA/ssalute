# Self-Hosting Ssalute

This guide walks you through setting up your own instance of Ssalute on a Linux server. It assumes you are comfortable with a terminal but not necessarily with Laravel specifically.

We use [Laravel Forge](https://forge.laravel.com) to provision and manage our production server. Forge automates most of what this guide describes (PHP, Nginx, SSL, databases, queue workers, deployments). If you would like a managed experience, Forge is an excellent option and supports DigitalOcean, AWS, Hetzner, Vultr, Linode, and custom VPS providers. The rest of this guide covers doing it yourself.


## Prerequisites

You will need:

- A Linux server (Ubuntu 22.04 or 24.04 recommended) with at least 2 GB RAM
- A domain name pointed at your server's IP address
- An S3-compatible storage bucket (AWS S3, DigitalOcean Spaces, MinIO, etc.)
- An SMTP mail service (Amazon SES, Postmark, Resend, Mailgun, or any SMTP provider)
- SSH access to the server with sudo privileges


## 1. System Packages

Update the system and install the required packages:

```bash
sudo apt update && sudo apt upgrade -y

sudo apt install -y \
    software-properties-common \
    curl \
    git \
    unzip \
    zip \
    supervisor \
    ufw
```


## 2. PHP 8.4

Install PHP 8.4 and the required extensions:

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install -y \
    php8.4-fpm \
    php8.4-cli \
    php8.4-mysql \
    php8.4-mbstring \
    php8.4-xml \
    php8.4-curl \
    php8.4-zip \
    php8.4-bcmath \
    php8.4-gd \
    php8.4-intl \
    php8.4-pcntl \
    php8.4-redis \
    php8.4-imagick
```

Verify the installation:

```bash
php -v        # Should show PHP 8.4.x
php -m        # Should list all installed extensions
```

### PHP Configuration

For production, edit `/etc/php/8.4/fpm/php.ini`:

```ini
upload_max_filesize = 64M
post_max_size = 64M
memory_limit = 256M
max_execution_time = 60
```

Restart PHP-FPM after changes:

```bash
sudo systemctl restart php8.4-fpm
```


## 3. MySQL 8

```bash
sudo apt install -y mysql-server-8.0

sudo mysql_secure_installation
```

Create the database and a dedicated user:

```sql
sudo mysql -e "
CREATE DATABASE ssalute CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ssalute'@'localhost' IDENTIFIED BY 'YOUR_SECURE_PASSWORD';
GRANT ALL PRIVILEGES ON ssalute.* TO 'ssalute'@'localhost';
FLUSH PRIVILEGES;
"
```

Replace `YOUR_SECURE_PASSWORD` with a strong, unique password.


## 4. Redis

```bash
sudo apt install -y redis-server
```

Redis is used for queues, caching, and sessions. Verify it is running:

```bash
redis-cli ping   # Should return PONG
```

For production, edit `/etc/redis/redis.conf` and set `maxmemory` and `maxmemory-policy`:

```
maxmemory 256mb
maxmemory-policy allkeys-lru
```

Restart Redis:

```bash
sudo systemctl restart redis-server
```


## 5. Nginx

```bash
sudo apt install -y nginx
```

Create a site configuration at `/etc/nginx/sites-available/ssalute`:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/ssalute/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    client_max_body_size 64M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site and reload Nginx:

```bash
sudo ln -s /etc/nginx/sites-available/ssalute /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```


## 6. SSL with Let's Encrypt

```bash
sudo apt install -y certbot python3-certbot-nginx

sudo certbot --nginx -d your-domain.com
```

Certbot will automatically modify your Nginx config to handle HTTPS and set up auto-renewal.


## 7. Node.js 20+

Node is needed to compile frontend assets. It is not needed at runtime.

```bash
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo bash -
sudo apt install -y nodejs

node -v   # Should show v22.x
npm -v    # Should show v10.x
```


## 8. Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```


## 9. Application Setup

### Clone the Repository

```bash
sudo mkdir -p /var/www/ssalute
sudo chown $USER:www-data /var/www/ssalute

git clone https://github.com/your-org/ssalute.git /var/www/ssalute
cd /var/www/ssalute
```

### Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

### Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure the following sections. Each variable is explained below.

#### Application

```env
APP_NAME="Ssalute"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

`APP_URL` must match the domain you configured in Nginx and SSL.

#### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ssalute
DB_USERNAME=ssalute
DB_PASSWORD=YOUR_SECURE_PASSWORD
```

Use the credentials you created in Step 3.

#### Redis

```env
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null
```

#### Cache, Queue, and Sessions

```env
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
```

#### S3 Storage

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=your-region
AWS_BUCKET=your-bucket-name
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

For S3-compatible providers (DigitalOcean Spaces, MinIO, etc.), set `AWS_ENDPOINT` to the provider's endpoint URL and set `AWS_USE_PATH_STYLE_ENDPOINT=true` if required by your provider.

#### Mail

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="Ssalute"
```

If using Amazon SES instead of SMTP:

```env
MAIL_MAILER=ses
AWS_DEFAULT_REGION=your-region
```

SES will use the same AWS credentials configured in the S3 section. If your SES credentials differ from S3, set `SES_AWS_ACCESS_KEY` and `SES_AWS_SECRET_ACCESS_KEY` separately.

#### Authentication

```env
SCOUTS_DIGITAL_AUTHENTICATION_ENCRYPTION_KEY=a-long-random-string-at-least-32-characters
SSALUTE_SUPERUSER_EMAIL=admin@your-domain.com
```

Generate a random key with: `openssl rand -hex 32`

#### Optional: Sentry (Error Tracking)

```env
SENTRY_LARAVEL_DSN=https://your-sentry-dsn
SENTRY_ENVIRONMENT=production
```

#### Optional: Slack Alerts

```env
SLACK_ALERT_ENABLED=true
SLACK_ALERT_WEBHOOK=https://hooks.slack.com/services/your/webhook/url
```

### Run Migrations

```bash
php artisan migrate --force
```

### Storage Symlink

```bash
php artisan storage:link
```

### File Permissions

```bash
sudo chown -R $USER:www-data /var/www/ssalute
sudo chmod -R 775 /var/www/ssalute/storage
sudo chmod -R 775 /var/www/ssalute/bootstrap/cache
```


## 10. Queue Worker (Horizon)

Ssalute uses Laravel Horizon to manage Redis queues. Horizon needs to run as a persistent background process.

Create a Supervisor configuration at `/etc/supervisor/conf.d/ssalute-horizon.conf`:

```ini
[program:ssalute-horizon]
process_name=%(program_name)s
command=php /var/www/ssalute/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/ssalute/storage/logs/horizon.log
stopwaitsecs=3600
```

Start it:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ssalute-horizon
```

Verify Horizon is running:

```bash
sudo supervisorctl status ssalute-horizon
```


## 11. Scheduled Tasks (Cron)

Laravel's task scheduler needs to run every minute. Add a cron entry:

```bash
sudo crontab -u www-data -e
```

Add this line:

```
* * * * * cd /var/www/ssalute && php artisan schedule:run >> /dev/null 2>&1
```


## 12. Firewall

Configure UFW to allow only the necessary ports:

```bash
sudo ufw allow 22/tcp     # SSH
sudo ufw allow 80/tcp     # HTTP (redirects to HTTPS)
sudo ufw allow 443/tcp    # HTTPS
sudo ufw enable
```


## 13. Final Checks

Run through these to verify everything is working:

```bash
# Application responds
curl -I https://your-domain.com

# Health check endpoint
curl https://your-domain.com/up

# Horizon is processing jobs
php artisan horizon:status

# Redis is connected
php artisan tinker --execute="echo cache()->store('redis')->put('test', 'ok', 10) ? 'Cache OK' : 'Cache FAIL';"

# Database is connected
php artisan tinker --execute="echo \DB::connection()->getPdo() ? 'DB OK' : 'DB FAIL';"

# Mail is configured (sends a test to your superuser email)
php artisan tinker --execute="Mail::raw('Ssalute mail test', fn(\$m) => \$m->to(config('ssalute.superuser_email'))->subject('Test'));"
```


## Deployment Updates

When pulling new code:

```bash
cd /var/www/ssalute

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Restart queue workers
php artisan horizon:terminate
```

Horizon's Supervisor config will automatically restart it after termination.


## Monitoring

Once running, the following dashboards are available (restricted to the superuser):

- **Horizon** at `/horizon` for queue monitoring
- **Pulse** at `/pulse` for application performance monitoring


## Troubleshooting

**502 Bad Gateway from Nginx**
Check that PHP-FPM is running: `sudo systemctl status php8.4-fpm`. Verify the socket path in your Nginx config matches the FPM pool config.

**Queue jobs are not processing**
Check Horizon status: `sudo supervisorctl status ssalute-horizon`. Review logs at `storage/logs/horizon.log`.

**"Permission denied" errors in storage/**
Fix ownership: `sudo chown -R $USER:www-data storage bootstrap/cache` and permissions: `sudo chmod -R 775 storage bootstrap/cache`.

**Assets not loading (404 on CSS/JS)**
Rebuild frontend assets: `npm run build`. Verify `storage:link` has been run.

**SSL certificate not renewing**
Test renewal: `sudo certbot renew --dry-run`. Certbot installs a systemd timer by default. Check with: `sudo systemctl status certbot.timer`.

**Redis connection refused**
Verify Redis is running: `sudo systemctl status redis-server`. Check that `REDIS_HOST` and `REDIS_PORT` in `.env` match your Redis configuration.
