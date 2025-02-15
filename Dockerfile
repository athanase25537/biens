# Utiliser l'image officielle PHP 8.3.6 avec Apache
FROM php:8.3.6-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip mysqli 

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Modifier la configuration Apache pour définir DocumentRoot sur /var/www/html/Public
RUN sed -i 's|DocumentRoot /var/www/html.*|DocumentRoot /var/www/html/Public|' /etc/apache2/sites-available/000-default.conf



# Copier l'intégralité du projet dans le conteneur
COPY . /var/www/html

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour Apache
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
