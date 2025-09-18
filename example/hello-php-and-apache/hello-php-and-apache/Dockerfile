FROM ubuntu:23.10

RUN apt -y update
RUN apt -y upgrade
RUN apt -y install php8.2-fpm
RUN apt -y install apache2
RUN apt -y install libapache2-mod-fcgid

RUN a2enmod proxy_fcgi
RUN a2enconf php8.2-fpm

RUN mkdir -p /var/www/hello-php-and-apache/public
RUN chmod -R 755 /var/www
COPY site.conf /etc/apache2/sites-available/
COPY index.php /var/www/hello-php-and-apache/public

RUN a2dissite 000-default.conf
RUN a2ensite site.conf

EXPOSE 80

CMD service php8.2-fpm start; apachectl -D FOREGROUND
