FROM ubuntu

RUN apt update && apt upgrade -y \
&& apt install -y apache2
RUN mkdir -p /var/www/hello/public \
&& chmod -R 755 /var/www

COPY site.conf /etc/apache2/sites-available/
COPY index.html /var/www/hello/public/

RUN a2dissite 000-default.conf
RUN a2ensite site.conf

EXPOSE 80

CMD apachectl -D FOREGROUND
