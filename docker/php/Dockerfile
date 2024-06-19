FROM php:8.2-fpm
ENV TZ=Europe/Warsaw

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt update && apt install -y --no-install-recommends cmake \
    && docker-php-ext-install pdo pdo_mysql opcache sysvsem sockets \
    && usermod -u 1000 www-data \
    && apt-get clean autoclean && apt-get autoremove --yes && rm -rf /var/lib/{apt,dpkg,cache,log}/
    && ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TZ} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date" \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony
