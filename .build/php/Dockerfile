FROM php:8.4-fpm

RUN apt-get update -y && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install bcmath
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql

RUN apt-get update -y && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

# RUN pecl install mongodb \
#     && echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini 
# RUN echo "extension=pgsql.so" > $PHP_INI_DIR/conf.d/pgsql.ini 

RUN apt-get install nano -y

RUN apt-get update && \
    apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

# RUN apt-get update && apt-get install -y \
#     redis-server \
#     && pecl install redis \
#     && docker-php-ext-enable redis

# RUN apt-get update && apt-get install git -y

# RUN git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis
# RUN docker-php-ext-install redis

RUN apt-get update && apt-get install -y \
                libfreetype-dev \
                libjpeg62-turbo-dev \
                libpng-dev

# RUN apt-get update && apt-get install -y nodejs npm

RUN apt-get update && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-enable gd 
        # && docker-php-ext-enable mongodb

RUN apt-get update

# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN php composer-setup.php
# RUN php -r "unlink('composer-setup.php');"

ADD ./custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer
