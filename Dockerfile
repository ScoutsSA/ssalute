FROM php:8.4-cli-bookworm

# ── System dependencies ───────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    curl \
    git \
    jq \
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

# PECL extensions (Redis + Imagick)
RUN apt-get update && apt-get install -y libmagickwand-dev && rm -rf /var/lib/apt/lists/* \
    && pecl install redis imagick \
    && docker-php-ext-enable redis imagick

# ── PHP configuration ──────────────────────────────────────────────────────
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory.ini

# ── Composer ─────────────────────────────────────────────────────────────────
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# ── Node.js 22 ───────────────────────────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# ── GitHub CLI ───────────────────────────────────────────────────────────────
RUN curl -fsSL https://cli.github.com/packages/githubcli-archive-keyring.gpg \
    | dd of=/usr/share/keyrings/githubcli-archive-keyring.gpg \
    && chmod go+r /usr/share/keyrings/githubcli-archive-keyring.gpg \
    && echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/githubcli-archive-keyring.gpg] https://cli.github.com/packages stable main" \
    | tee /etc/apt/sources.list.d/github-cli.list > /dev/null \
    && apt-get update && apt-get install -y gh \
    && rm -rf /var/lib/apt/lists/*

# ── Non-root user ─────────────────────────────────────────────────────────────
RUN useradd -m -s /bin/bash claude

WORKDIR /app
RUN chown claude:claude /app

# ── Claude Code ──────────────────────────────────────────────────────────────
# Installed via npm for the initial image. The native auto-updater will
# take over at runtime and install to ~/.local, so we add that to PATH too.
RUN npm install -g @anthropic-ai/claude-code

USER claude
ENV PATH="/home/claude/.local/bin:${PATH}"

CMD ["bash"]
