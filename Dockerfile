FROM php:8.2-fpm


# 姑且先放常用依賴，不需要時再移除
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

COPY --from=composer:2.8.1 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# 方便日誌查看用(關閉laravel安裝log)
# NOTE: 使用 --prefer-dist 下載dist版本會導致 php artisan key:generate 報錯
# RUN composer install --prefer-dist --no-suggest --no-progress

# 一般執行
RUN composer install

RUN chown -R www-data:www-data /var/www

# 生成加密金鑰
RUN php artisan key:generate

EXPOSE 9000

CMD ["php-fpm"]
