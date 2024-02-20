# Usa la imagen oficial de PHP 8.1 con Apache
FROM php:8.1-apache

# Instala dependencias requeridas por Laravel
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip

# Habilita el módulo Apache mod_rewrite
RUN a2enmod rewrite

# Configura el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Instala las dependencias del proyecto con Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction --optimize-autoloader

# Copia el archivo de configuración de entorno
COPY .env.example .env

# Genera la clave de aplicación de Laravel
RUN php artisan key:generate

# Establece los permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80 para el servidor web
EXPOSE 80

# Comando para iniciar el servidor Apache
CMD php artisan serve --host=0.0.0.0 --port=80
