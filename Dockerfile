FROM php:8.4-fpm-alpine AS app_build

RUN apk add --no-cache \
        build-base \
        curl \
        freetype \
        freetype-dev \
        git \
        libjpeg-turbo \
        libjpeg-turbo-dev \
        libpng \
        libpng-dev \
        libxml2 \
        libxml2-dev \
        libzip \
        libzip-dev \
        mysql-client \
        nginx \
        nodejs \
        npm \
        oniguruma-dev \
        postgresql-dev \
        postgresql-libs \
        su-exec \
        supervisor \
        unzip \
        zip   

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_mysql pdo_pgsql zip gd mbstring exif pcntl bcmath 

WORKDIR /var/www/html

COPY . /var/www/html

RUN npm install && npm run build
RUN npm install --production --silent && npm cache clean --force

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --2

RUN composer install --optimize-autoloader --no-dev --no-interaction

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY ./docker/php/supervisord.conf /etc/supervisor/conf.d/app.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

RUN chmod +x /usr/local/bin/entrypoint.sh

RUN mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/public/build \ 
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/public \
    && chmod -R o+r /var/www/html/public \
    && chmod -R o+r /var/www/html/vendor

FROM php:8.4-fpm-alpine AS production

RUN apk add --no-cache \
        freetype \
        libjpeg-turbo \
        libpng \
        libxml2 \
        libzip \
        mysql-client \
        nginx \
        oniguruma \
        postgresql-libs \
        su-exec \
        supervisor 

COPY --from=app_build /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=app_build /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

WORKDIR /var/www/html

COPY --from=app_build /var/www/html /var/www/html
COPY --from=app_build /etc/supervisor/conf.d/app.conf /etc/supervisor/conf.d/app.conf
COPY --from=app_build /etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=app_build /etc/nginx/http.d/default.conf /etc/nginx/http.d/default.conf 
COPY --from=app_build /usr/local/bin/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY --from=app_build /usr/local/etc/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p /var/run/nginx /var/lib/nginx/tmp \
    && chown -R www-data:www-data /var/lib/nginx /var/run/nginx \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache /var/www/html/public /var/www/html/vendor \
    && rm -rf /var/cache/apk/* /tmp/* /usr/local/bin/composer /usr/local/bin/phpunit /root/.composer /root/.npm /root/.cache

VOLUME /var/www/html/storage

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --retries=3 \
  CMD curl -f http://localhost/health || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/app.conf"]