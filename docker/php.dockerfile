FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
#RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
      libonig-dev \
      libzip-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install exif \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
      mbstring \
      pcntl \
      pdo_mysql
      
      

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libssl-dev zlib1g-dev curl git unzip netcat \
    libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

    

#RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd \
#    && docker-php-ext-install pdo_mysql 

#RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

#RUN docker-php-ext-bz2 docker-php-ext-sodium docker-php-ext-zip
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
#    chown -R $user:$user /home/$user


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

#RUN chmod 777 -R storage/

USER $user
