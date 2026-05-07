# استخدام نسخة PHP الرسمية مع Apache
FROM php:8.2-apache

# 1. تثبيت الإضافات الضرورية و Node.js (مهم جداً لتيلواند)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql

# تفعيل mod_rewrite
RUN a2enmod rewrite

# ضبط المجلد الرئيسي
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# 2. تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-interaction

# 3. تثبيت حزم npm وبناء ملفات Tailwind CSS (Vite)
RUN npm install && npm run build

# 4. إعطاء الصلاحيات لمجلدات التخزين والتصميم
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build

# الأمر النهائي لتشغيل السيرفر وقاعدة البيانات والمهام الخلفية (Queue)
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan storage:link || true && \
    php artisan migrate --force || true && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build && \
    (php artisan queue:work &) && \
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    apache2-foreground
