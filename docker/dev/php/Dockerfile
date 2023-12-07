FROM php:8.2-fpm

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apt-get update && \
    apt-get install -y \
    wget \
    git \
    unzip \
    libpq-dev \
    zlib1g-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssh-dev \
    libpng-dev

RUN docker-php-ext-install zip && \
    docker-php-ext-install pdo && \
    docker-php-ext-install sockets && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install gd && \
    docker-php-ext-enable gd && \
    docker-php-ext-install pdo_pgsql

RUN pecl install redis && \
    docker-php-ext-enable redis

WORKDIR /var/www/html

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

RUN pecl install xdebug

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

ENV USER_ID=1000 GROUP_ID=1000

RUN addgroup --gid ${GROUP_ID} user

RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user

RUN usermod -a -G www-data user

RUN chown www-data: /var/www

RUN chmod 755 /var/www/

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 /var/www/html

RUN usermod -a -G www-data user

USER user

EXPOSE 9000
CMD ["php-fpm"]

