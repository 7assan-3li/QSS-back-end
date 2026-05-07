# استخدام نسخة PHP الرسمية مع Apache
FROM php:8.2-apache

# تثبيت الإضافات الضرورية
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# تفعيل mod_rewrite
RUN a2enmod rewrite

# ضبط المجلد الرئيسي
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# إعطاء الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# الأمر النهائي مع تجنب توقف السيرفر إذا فشل الميغريشن
CMD php artisan migrate --force || true && \
    php artisan db:seed --force || true && \
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    apache2-foreground