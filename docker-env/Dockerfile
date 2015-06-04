FROM php:5.6-apache
COPY php.ini /usr/local/etc/php/php.ini
RUN apt-get update \
&& apt-get install -qy libmcrypt-dev zlib1g-dev libpqxx-dev \
&& docker-php-ext-install pdo pgsql pdo_pgsql mcrypt mbstring zip \
&& apt-get clean \
&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/app/g' /etc/apache2/apache2.conf \
&& sed -i 's/Directory \/var\/www/Directory \/app/g' /etc/apache2/apache2.conf \
&& usermod -u 1000 www-data \
&& a2enmod rewrite \
&& mkdir /app \
&& chown -R www-data:www-data /app \
&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
&& apache2ctl restart