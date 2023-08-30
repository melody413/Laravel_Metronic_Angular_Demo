######################## OK FILE only mysqli issue ######
# Use the official PHP image as the base image
FROM php:7.4-fpm-alpine

ARG APP_NAME
ARG APP_ENV
ARG DB_HOST
ARG DB_PORT
ARG DB_NAME
ARG DB_USER
ARG DB_PASSWORD
ARG APP_BASE_URL


# Set the working directory to /app
WORKDIR /var/www/html

# Copy the composer.json and composer.lock files to the container
#COPY composer.json composer.lock ./

# Install dependencies
RUN apk update && apk add --no-cache \
    nginx \
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    mariadb-client \
    vim \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        gd \
        bcmath \
        opcache \
        sockets \
    && docker-php-ext-enable mysqli \
        && apk del --no-cache \
            zlib-dev \
            libzip-dev \
            libpng-dev \
            libjpeg-turbo-dev \
            freetype-dev \
            oniguruma-dev \
    && rm -rf /var/cache/apk/*
RUN apk add --no-cache libpng-dev libzip-dev
RUN docker-php-ext-install gd zip mysqli pdo_mysql mbstring exif pcntl bcmath gd && docker-php-ext-enable mysqli
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the rest of the application files to the container
COPY . .
COPY nginx.conf /etc/nginx/conf.d/default.conf
# Generate the application key
RUN php artisan key:generate

# Set the application environment
#ENV APP_ENV=production
ENV APP_NAME=$APP_NAME
ENV APP_ENV=$APP_ENV
ENV DB_HOST=$DB_HOST
ENV DB_PORT=$DB_PORT
ENV DB_NAME=$DB_NAME
ENV DB_USER=$DB_USER
ENV DB_PASSWORD=$DB_PASSWORD
ENV APP_BASE_URL=$APP_BASE_URL


EXPOSE 80

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "80"]
##### NEW Data
## Use the official PHP image as the base image
#FROM php:7.4-fpm
#
#ARG APP_NAME
#ARG APP_ENV
#ARG DB_HOST
#ARG DB_PORT
#ARG DB_NAME
#ARG DB_USER
#ARG DB_PASSWORD
#ARG APP_BASE_URL
#
#
## Set the working directory to /app
#WORKDIR /var/www/html
#ENV COMPOSER_MEMORY_LIMIT=-1
## Install required packages
#RUN apt-get update && apt-get install -y \
#    nginx \
#    zlib1g-dev \
#    libzip-dev \
#    libpng-dev \
#    libjpeg-dev \
#    libfreetype6-dev \
#    libonig-dev \
#    mariadb-client \
#    && docker-php-ext-configure gd \
#        --with-freetype \
#        --with-jpeg \
#    && docker-php-ext-install \
#        pdo_mysql \
#        zip \
#        gd \
#        bcmath \
#        opcache \
#        sockets \
#        mysqli \
#    && apt-get clean \
#    && rm -rf /var/lib/apt/lists/*
#
## Install composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#
## Copy the rest of the application files to the container
#COPY package*.json ./
#COPY composer* ./
#COPY . .
## Copy the Nginx configuration file
#COPY nginx.conf /etc/nginx/conf.d/default.conf
#
## Generate the application key
#RUN php artisan key:generate
#
## Set the application environment
#ENV APP_NAME=$APP_NAME
#ENV APP_ENV=$APP_ENV
#ENV DB_HOST=$DB_HOST
#ENV DB_PORT=$DB_PORT
#ENV DB_NAME=$DB_NAME
#ENV DB_USER=$DB_USER
#ENV DB_PASSWORD=$DB_PASSWORD
#ENV APP_BASE_URL=$APP_BASE_URL
#
## Expose port 80
#EXPOSE 80
#
## Start the application
#CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "80"]
#
##php artisan server --host 0.0.0.0 --port 80