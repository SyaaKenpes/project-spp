# Menggunakan image PHP 8.3 versi CLI (Command Line Interface)
FROM php:8.3-cli

# Set working directory
WORKDIR /var/www

# Install dependencies sistem yang wajib
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev

# Bersihkan cache untuk memperkecil ukuran image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP untuk Laravel dan MySQL
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin semua file project
COPY . /var/www

# Berikan izin akses folder
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Buka port 8080
EXPOSE 8080

# Jalankan server bawaan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]