FROM php:8.4-cli-bookworm

# ── System dependencies ───────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# ── PHP extensions ────────────────────────────────────────────────────────────
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_sqlite \
        mbstring \
        zip \
        bcmath \
        gd \
        intl \
        pcntl \
        dom \
        xml

# Redis extension (C extension, installed via PECL)
RUN pecl install redis && docker-php-ext-enable redis

# ── PHP configuration ──────────────────────────────────────────────────────
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory.ini

# ── Composer ─────────────────────────────────────────────────────────────────
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# ── Node.js 22 ───────────────────────────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# ── Claude Code ──────────────────────────────────────────────────────────────
RUN npm install -g @anthropic-ai/claude-code

# ── Non-root user ─────────────────────────────────────────────────────────────
RUN useradd -m -s /bin/bash claude

WORKDIR /app
RUN chown claude:claude /app

USER claude

CMD ["bash"]
