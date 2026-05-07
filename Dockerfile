# استخدام نسخة PHP الرسمية مع Apache
FROM php:8.2-apache

# تثبيت الإضافات الضرورية لـ Laravel و PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# تفعيل خاصية mod_rewrite في Apache (ضرورية لـ Laravel)
RUN a2enmod rewrite

# ضبط المجلد الرئيسي للموقع ليشير إلى مجلد public داخل Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ ملفات المشروع إلى السيرفر
COPY . /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# إعطاء الصلاحيات اللازمة لمجلدات Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تشغيل السيرفر على البورت الذي يحدده Render
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && docker-php-ext-install pdo pdo_pgsql && apache2-foreground