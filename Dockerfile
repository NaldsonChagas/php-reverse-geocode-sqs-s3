FROM php:8.2-cli

WORKDIR /var/www/html

COPY src/ /var/www/html/src/

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY .env .env

RUN apt-get update && apt-get install -y git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"  \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer  \
    && php -r "unlink('composer-setup.php');" && composer install --no-dev --optimize-autoloader

CMD ["php", "src/app.php"]
