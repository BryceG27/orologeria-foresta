FROM php:8.4-fpm-bookworm

# Installa dipendenze di sistema e PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    git \
    curl \
    bash \
    libicu-dev \
    libxml2-dev \
    libxslt1-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        pdo \
        pdo_mysql \
        bcmath \
        intl \
        soap \
        xsl \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installa Composer
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www

# Copia progetto
COPY . .

# Permessi (importante per Laravel)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www