FROM php:7.1-apache-jessie

COPY index.php /var/www/html/index.php
COPY secure_db.php /var/www/html/secure_db.php
COPY site.db /var/www/html/site.db

RUN chown -R www-data:www-data /var/www/

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
