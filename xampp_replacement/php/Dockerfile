FROM php:8.3.17-apache

# Needed for building most of the php modules
RUN apt-get update && apt-get install -y \
	libfreetype-dev \
	libzip-dev \
	libbz2-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libgmp-dev

# Modules and disable default sites to enable custom one, plus enable apache modules
COPY ./apache/main-site-ssl.conf /etc/apache2/sites-available/main-site-ssl.conf
COPY ./apache/ports.conf /etc/apache2/ports.conf
RUN a2enmod ssl && a2enmod rewrite && a2enmod allowmethods && a2enmod headers && a2enmod include  \
	&& a2enmod info && a2enmod cache_disk && a2enmod proxy \
	&& a2dissite 000-default default-ssl \
	&& a2ensite main-site-ssl

# Set PHP config
COPY ./php.ini /usr/local/etc/php/php.ini-development

# Copy certificates for SSL
RUN mkdir -p /etc/apache2/ssl
COPY ./ssl/*.pem /etc/apache2/ssl/

# Install all php extensions needed, configuring and enabling them
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install pdo_mysql mysqli bz2 gd gettext gmp exif zip \
	&& docker-php-ext-enable pdo_mysql mysqli bz2 gd gettext gmp exif zip
# We can also enable xdebug if needed, comment if not to lighten the image
#	Has some interesting functions, like xdebug_peak_memory_usage(), docs: https://xdebug.org/docs/develop
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install Composer 
#COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
	mv /var/www/html/composer.phar /usr/local/bin/composer

# Clean install cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Stablish working directory for the rest of the script and terminal
WORKDIR /var/www/html

# Install composer dependencies - TODO!
#RUN composer install --no-interaction --prefer-dist

EXPOSE 80
EXPOSE 443