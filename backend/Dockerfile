# Используем официальный образ PHP с Apache
FROM php:8.1-apache

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git

# Устанавливаем расширения PHP для работы с Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Копируем Composer из официального образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем проект в контейнер
COPY . /var/www/html/

# Устанавливаем правильные права на папки Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Включаем mod_rewrite для Apache (для чистых URL в Laravel)
RUN a2enmod rewrite

# Открываем порт 80
EXPOSE 80

# Запускаем Apache
CMD ["apache2-foreground"]
