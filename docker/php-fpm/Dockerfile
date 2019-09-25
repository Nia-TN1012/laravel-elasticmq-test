FROM debian:buster-slim

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        apt-transport-https \
        curl \
        unzip \
        zlib1g-dev \
        php7.3 \
        php7.3-fpm \
            php7.3-mysql \
            php7.3-xml \
            php7.3-mbstring \
            php-oauth \
            php7.3-zip \
    && rm -rf /var/lib/apt/lists/* \
    # php-fpmのListenをソケットから9000/tcpに変更します。
    && sed -iE '/^listen/s/\/run\/php\/php7\.3-fpm\.sock/9000/g' /etc/php/7.3/fpm/pool.d/www.conf \
    && mkdir -p /var/www/html \
    && mkdir -p /run/php \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# composerをrootで実行できるようにします。
ENV COMPOSER_ALLOW_SUPERUSER 1

# Laravelのソースコードのフォルダを作業ディレクトリにします。
WORKDIR /var/www/html
EXPOSE 9000
# `docker-compose up`実行時、`/usr/sbin/php-fpm7.3 -F`で起動するようにします。
CMD [ "/usr/sbin/php-fpm7.3", "-F" ]