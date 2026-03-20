# Utiliser l'image officielle d'Apache avec PHP
FROM php:8.1-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Copier les fichiers locaux dans le conteneur
COPY . /var/www/html/

# Définir le répertoire de travail
WORKDIR /var/www/html/

# Exposer le port 80 pour que l'application soit accessible
EXPOSE 80

# Lancer Apache en mode avant-garde
CMD ["apache2-foreground"]
