FROM debian:12

RUN apt-get update && apt-get install -y \
    apache2 \
    php8.2 \
    php8.2-mysql \
    libapache2-mod-php8.2 \
    curl \
    iproute2 \
    openssh-client \
    && rm -rf /var/lib/apt/lists/*

# Configuration Apache
RUN a2enmod rewrite php8.2

# Copier les fichiers web
COPY www/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN chmod 755 /var/www/html

EXPOSE 80

#CMD ["apachectl", "-D", "FOREGROUND"]
