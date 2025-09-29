FROM ubuntu:23.10

RUN apt -y update
RUN apt -y upgrade
RUN apt -y install mysql-server-8.0

RUN sed -i "s|bind-address		= 127.0.0.1|#bind-address		= 127.0.0.1 |g" /etc/mysql/mysql.conf.d/mysqld.cnf

COPY database.sql /var/tmp/
RUN service mysql start && \
    echo "source /var/tmp/database.sql" | mysql

EXPOSE 3306

CMD mysqld_safe
