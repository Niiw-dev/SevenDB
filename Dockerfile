FROM php:8.2-cli-bookworm

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        libpq-dev \
        libzip-dev \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        mbstring \
        pdo_pgsql \
        pgsql \
        zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/app

ENTRYPOINT ["php", "artisan"]