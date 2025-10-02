FROM ubuntu:latest

RUN apt update && apt upgrade -y \
    && apt install -y php8.3-fpm apache2 libapache2-mod-fcgid php8.3-mysql \
    && a2enmod proxy_fcgi && a2enconf php8.3-fpm

COPY site.conf /etc/apache2/sites-available/
COPY index.php /var/www/hello-php-apache-from-scratch/public/

RUN a2dissite 000-default.conf && a2ensite site.conf

COPY start-services.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start-services.sh

CMD ["/usr/local/bin/start-services.sh"]
