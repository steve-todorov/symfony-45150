FROM phpdockerio/php74-fpm:latest

COPY --from=composer:1.10.22 /usr/bin/composer /usr/bin/composer
#COPY --from=composer:2.2.4 /usr/bin/composer /usr/bin/composer

WORKDIR "/application"

RUN set -x \
 && curl -fsSL https://deb.nodesource.com/setup_12.x | bash - \
 && apt-get update \
 && apt-get -y --no-install-recommends install git nodejs openssh-client rsync sudo postgresql-client \
    php7.4-cli \
    php7.4-curl \
    php7.4-json \
    php7.4-gd \
    php7.4-intl \
    php7.4-memcached \
    php7.4-opcache \
    php7.4-pgsql \
    php7.4-readline \
    php7.4-sqlite3 \
    php7.4-xdebug \
    php7.4-xml \
    php7.4-yaml \
    php7.4-zip \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

CMD ["/bin/bash", "-c", "composer install && php bin/console server:run 0.0.0.0:8000" ]
