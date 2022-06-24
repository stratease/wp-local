#
# NOTE: THIS DOCKERFILE IS GENERATED VIA "apply-templates.sh"
#
# PLEASE DO NOT EDIT IT DIRECTLY.
#
FROM wordpress
RUN apt-get update && apt-get install vim default-mysql-client -y
RUN pecl install xdebug-3.1.0beta2 && docker-php-ext-enable xdebug
RUN docker-php-ext-install pcntl
# Append our Docker xdebug configuration for our IDE to debug on port 9003.
COPY php.ini /usr/local/etc/php/conf.d/docker-php.ini

# persistent dependencies
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp
