FROM php:8.2-fpm

# Устанавливаем только essentials
RUN apt-get update && apt-get install -y \
    curl \
    librdkafka-dev

# Устанавливаем rdkafka
RUN pecl install rdkafka && docker-php-ext-enable rdkafka

WORKDIR /var/www/html

# Копируем файлы проекта
COPY . .

# Устанавливаем Composer вручную
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Пробуем установить зависимости
RUN composer install --no-dev --ignore-platform-reqs || true

CMD ["php-fpm"]