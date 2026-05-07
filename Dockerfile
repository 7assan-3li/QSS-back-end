# استخدام نسخة PHP الرسمية مع Apache
FROM php:8.2-apache

# تثبيت الإضافات الضرورية لـ Laravel و PostgreSQL و Node.js
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql zip

# تفعيل خاصية mod_rewrite في Apache
RUN a2enmod rewrite

# ضبط المجلد الرئيسي للموقع
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# بناء ملفات الـ CSS والـ JS (Vite/Mix)
RUN npm install && npm run build

# إعطاء الصلاحيات اللازمة
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# الأمر النهائي لتشغيل السيرفر وتنفيذ العمليات المطلوبة
# ملاحظة: تم إضافة الميغريشن والسييدر وتشغيل الكيو في الخلفية
CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    npm run build && \
    (php artisan queue:work --daemon &) && \
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    apache2-foreground