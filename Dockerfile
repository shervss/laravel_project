FROM php:8.5-fpm

ENV TMPDIR=/usr/share/nginx/html/storage/framework/cache/data

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=node:22 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22 /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /usr/share/nginx/html

COPY . .

RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY ./scripts/php-fpm-entrypoint /usr/local/bin/php-entrypoint

RUN chmod +x /usr/local/bin/php-entrypoint

ENTRYPOINT ["/usr/local/bin/php-entrypoint"]

CMD ["php-fpm"]