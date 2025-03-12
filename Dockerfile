# Usa una imagen oficial de PHP con extensiones necesarias
FROM php:8.1-fpm

# Instala dependencias del sistema y Nginx
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto al contenedor
WORKDIR /var/www
COPY . /var/www

# Copia la configuración de Nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Da permisos a los archivos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expone los puertos para Nginx y PHP-FPM
EXPOSE 80 9000

# Inicia Nginx y PHP-FPM
CMD service nginx start && php-fpm
