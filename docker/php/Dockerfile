FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath intl zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
