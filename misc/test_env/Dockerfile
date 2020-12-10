ARG PHP_VERSION=7.4
FROM composer


ARG PHP_VERSION=7.4
FROM php:$PHP_VERSION-cli
ENV DEBIAN_FRONTEND noninteractive
COPY --from=0 /usr/bin/composer /usr/bin/composer
WORKDIR /app

RUN apt update && \
    apt -y install git unzip zlib1g-dev libzip-dev libpng-dev wget && \
    docker-php-ext-install zip && \
    docker-php-ext-install gd && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony