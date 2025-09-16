FROM ubuntu

COPY site.conf /etc/apache2/sites-available/
COPY index.html /var/www/hello/public/

RUN apt update && apt upgrade -y \
&& apt install -y apache2 \
&& a2dissite 000-default.conf && a2ensite site.conf

EXPOSE 80

CMD apachectl -D FOREGROUND
