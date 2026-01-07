# Base image PHP 8.1 FPM
FROM php:8.1-fpm

# Install dependencies: MySQL, Nginx, Supervisor, tools, Git, Composer dependencies
RUN apt-get update && apt-get install -y \
    mariadb-server \
    nginx \
    supervisor \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    locales \
    curl \
    && docker-php-ext-install mysqli pdo pdo_mysql intl \
    && rm -rf /var/lib/apt/lists/*

# Set locale supaya tidak warning
RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www/html

# Expose ports
EXPOSE 80 3306

# Start supervisor (PHP-FPM, Nginx, MySQL)
CMD ["/usr/bin/supervisord", "-n"]
