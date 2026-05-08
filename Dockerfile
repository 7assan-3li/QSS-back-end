# المرحلة الأولى: بناء ملفات الـ Frontend
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install --frozen-lockfile --network-timeout 100000
COPY . .
RUN npm run build

# المرحلة الثانية: بناء صورة الـ PHP
FROM php:8.2-apache

# تثبيت الإضافات الضرورية
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# زيادة حدود الرفع ومعالجة البيانات
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 110M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

RUN a2enmod rewrite

# إعداد المجلد الرئيسي
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ ملفات الحزم أولاً لتحسين الكاش
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction --no-dev

# نسخ المشروع
COPY . .
COPY --from=frontend-builder /app/public/build ./public/build

# تحسين الأداء
RUN composer dump-autoload --optimize --no-dev && \
    php artisan core:link || true && \
    chown -R www-data:www-data storage bootstrap/cache public/build

# التوافق مع Render (المنفذ 80 كافتراضي إذا لم يتوفر $PORT)
ENV PORT=80

CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    php artisan storage:link --force || true && \
    php artisan migrate --force || true && \
    (php artisan queue:work --tries=3 --timeout=90 &) && \
    apache2-foreground
