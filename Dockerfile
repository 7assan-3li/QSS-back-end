# المرحلة الأولى: بناء ملفات الـ Frontend (Vite/Tailwind)
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# المرحلة الثانية: بناء صورة الـ PHP النهائية
FROM php:8.2-apache

# 1. تثبيت الإضافات الضرورية (PostgreSQL, Zip, Curl)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. تفعيل mod_rewrite للأباتشي
RUN a2enmod rewrite

# 3. ضبط المجلد الرئيسي (Document Root) لـ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. تثبيت Composer من الصورة الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. تحسين الكاش (نسخ ملفات الـ Composer أولاً)
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# 6. نسخ بقية ملفات المشروع
COPY . .

# 7. نسخ ملفات الـ Frontend المبنية من المرحلة الأولى
COPY --from=frontend-builder /app/public/build ./public/build

# 8. إنهاء تثبيت Composer مع تحسين التحميل التلقائي
RUN composer dump-autoload --optimize

# 9. ضبط الصلاحيات للمجلدات الضرورية
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build

# الأمر النهائي لتشغيل السيرفر
# يتضمن: ربط التخزين، الهجرة، تشغيل الكيو (في الخلفية)، وضبط المنفذ الديناميكي
CMD php artisan storage:link --force || true && \
    php artisan migrate --force || true && \
    (php artisan queue:work --tries=3 &) && \
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    apache2-foreground
