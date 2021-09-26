FROM php:7.4.0-fpm

RUN apt-get update && apt-get install -y \
		curl \
		wget \
		git \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		zlib1g-dev \
		libpng-dev \
		libonig-dev \
		libzip-dev \
		libpq-dev \
		libcurl4-openssl-dev \
	&& pecl install -o redis \
	&& docker-php-ext-enable redis \
	&& docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-install -j$(nproc) mbstring \
	&& docker-php-ext-install -j$(nproc) mysqli \
	&& docker-php-ext-install -j$(nproc) pdo_mysql \
	&& docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

CMD ["php-fpm"]
