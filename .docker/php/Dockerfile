FROM php:8.0.5-fpm

# Set working directory
WORKDIR /var/www

# Install ubuntu dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    zlib1g-dev libzip-dev libz-dev \
    libpng-dev \
    libxml2-dev \
    libssl-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip unzip \
    jpegoptim optipng pngquant gifsicle \
    vim make nano \
    wget \
    git \
    curl \
    sudo \
    ssh-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install NODE and NPM
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# optional, check locations and packages are correct
#CMD ["node -v"]
#CMD ["nonpmde -v"]


# Add user to OS
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
#COPY . /var/www

# Copy existing application directory permissions
#RUN chown -R www:www /var/www && usermod -u 1000 www

# Change current user to www
#USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
