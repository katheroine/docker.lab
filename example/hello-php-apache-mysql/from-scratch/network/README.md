# Example: Hello World web application in PHP on Apache with MySQL from scratch

## Two containers & network

### Creating network

`docker network create hello-php-apache-mysql`

* `network create` - creating a network
* `hello-php-apache-mysql` - network name

```console
$ docker network ls
NETWORK ID     NAME      DRIVER    SCOPE
c294fa0eb3b6   bridge    bridge    local
e7d6d7973119   host      host      local
f3babe8fdced   none      null      local
```

All listed networks are created by Docker by default and cannot be removed.

```console
$ docker network create hello-php-apache-mysql
a18fa9c67ad4df7e58001c899d0f12b1802e4f0435eb69af7357b72f965337b5
```

```console
$ docker network ls
NETWORK ID     NAME                     DRIVER    SCOPE
c294fa0eb3b6   bridge                   bridge    local
a18fa9c67ad4   hello-php-apache-mysql   bridge    local
e7d6d7973119   host                     host      local
f3babe8fdced   none                     null      local
```

### Creating MySQL image & container

#### Creating Dockerfile

[**Dockerfile**](hello-mysql/Dockerfile)

```dockerfile
FROM ubuntu:latest

RUN apt update && apt upgrade -y \
    && apt install -y mysql-server-8.0

RUN sed -i "s|bind-address		= 127.0.0.1|#bind-address		= 127.0.0.1 |g" /etc/mysql/mysql.conf.d/mysqld.cnf

COPY database.sql /var/tmp/
RUN service mysql start \
    && echo "source /var/tmp/database.sql" | mysql

EXPOSE 3306

CMD ["mysqld_safe"]

```

#### Preparing SQL script

[**database.sql**](hello-mysql/database.sql)

```sql
CREATE DATABASE hello;

CREATE USER 'hello' IDENTIFIED BY 'hello';
GRANT ALL ON hello.* TO 'hello'@'%';

USE hello;
CREATE TABLE fruits (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255),
    colour varchar(255)
);
INSERT INTO fruits
    (name, colour)
VALUES
    ('orange', 'orange'),
    ('apple', 'red'),
    ('pear', 'yellow');

```

#### Building image

`docker build -t hello-mysql-from-scratch .`

* `build` - building a container
* `-t` tags an image with a name
* `hello-mysql-from-scratch` - image name
* `.` - lets Docker know where it can find the Dockerfile

```console
$ docker build -t hello-mysql-from-scratch .
[+] Building 127.5s (10/10) FINISHED                                                                                                                                                                                                                               docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 378B                                                                                                                                                                                                                                         0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             1.4s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/5] FROM docker.io/library/ubuntu:latest@sha256:353675e2a41babd526e2b837d7ec780c2a05bca0164f7ea5dbbd433d21d166fc                                                                                                                                                0.0s
 => => resolve docker.io/library/ubuntu:latest@sha256:353675e2a41babd526e2b837d7ec780c2a05bca0164f7ea5dbbd433d21d166fc                                                                                                                                                       0.0s
 => [internal] load build context                                                                                                                                                                                                                                            0.0s
 => => transferring context: 34B                                                                                                                                                                                                                                             0.0s
 => [2/5] RUN apt update && apt upgrade -y     && apt -y install mysql-server-8.0                                                                                                                                                                                          103.9s
 => [3/5] RUN sed -i "s|bind-address  = 127.0.0.1|#bind-address  = 127.0.0.1 |g" /etc/mysql/mysql.conf.d/mysqld.cnf                                                                                                                                                          0.7s
 => [4/5] COPY database.sql /var/tmp/                                                                                                                                                                                                                                        0.1s
 => [5/5] RUN service mysql start     && echo "source /var/tmp/database.sql" | mysql                                                                                                                                                                                         4.5s
 => exporting to image                                                                                                                                                                                                                                                      16.7s
 => => exporting layers                                                                                                                                                                                                                                                     16.6s
 => => writing image sha256:32eae7d30853b4b7ed5d5b4c34e5c3b7bfa891af1751632d7961c57130c32862                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/hello-mysql-from-scratch                                                                                                                                                                                                                  0.0s
```

```console
$ docker images
REPOSITORY                 TAG       IMAGE ID       CREATED         SIZE
hello-mysql-from-scratch   latest    32eae7d30853   2 minutes ago   970MB
```

#### Creating container

`docker run -d -p 3307:3306 --name hello-world-with-mysql-from-scratch --network hello-php-apache-mysql hello-mysql-from-scratch`

* `run` - running new container
* `-d` - detached mode (running in the background)
* `-p 3307:3306` - mapping port 3307 on the Docker host to TCP port 3306 in the container
* `--name hello-world-with-mysql-from-scratch` - container name
* `--network hello-php-apache-mysql` - the network the container is connected to
* `hello-mysql-from-scratch` - a particular local image

```console
$ docker run -d -p 3307:3306 --name hello-world-with-mysql-from-scratch --network hello-php-apache-mysql hello-mysql-from-scratch
ebee4d572a942e90468df7a997596bdb04986a5208d99d0a7d39f0815685a5bd
```

```console
$ docker ps -a
CONTAINER ID   IMAGE                      COMMAND         CREATED          STATUS          PORTS                                         NAMES
ebee4d572a94   hello-mysql-from-scratch   "mysqld_safe"   45 seconds ago   Up 44 seconds   0.0.0.0:3307->3306/tcp, [::]:3307->3306/tcp   hello-world-with-mysql-from-scratch
```

#### Logging into container

`docker exec -it hello-world-with-mysql-from-scratch /bin/bash`

* `exec` - execute command on the docker container
* `-it` - iteractive mode with terminal attached
* `hello-world-with-mysql-from-scratch` - container name
* `/bin/bash` - the command

```console
$ docker exec -it hello-world-with-mysql-from-scratch /bin/bash
root@ebee4d572a94:/# mysql
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.43-0ubuntu0.24.04.2 (Ubuntu)

Copyright (c) 2000, 2025, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| hello              |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)

mysql> use hello;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
mysql> show tables;
+-----------------+
| Tables_in_hello |
+-----------------+
| fruits          |
+-----------------+
1 row in set (0.00 sec)

mysql> select * from fruits;
+----+--------+--------+
| id | name   | colour |
+----+--------+--------+
|  1 | orange | orange |
|  2 | apple  | red    |
|  3 | pear   | yellow |
+----+--------+--------+
3 rows in set (0.00 sec)

mysql>
```

### Creating PHP & Apache image & container

#### Creating Dockerfile

[**Dockerfile**](hello-php-apache/Dockerfile)

```dockerfile
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

```

#### Preparing services script

[**start-services.sh**](hello-php-apache/start-services.sh)

```bash
#!/bin/bash
service php8.3-fpm start
exec apachectl -D FOREGROUND

```

#### Preparing PHP application sample

[**index.php**](hello-php-apache/index.php)

```php
<h1>Hello, world!!!</h1>
<p>This is Docker example application in PHP <?php echo phpversion(); ?> on Apache.</p>

<?php
try {
    $connection = new mysqli('hello-world-with-mysql-from-scratch', 'hello', 'hello', 'hello');
    if ($connection->connect_error) {
      die('Database connection failed: ' . $connection->connect_error);
    }
    echo('<h3>Top popular fruits</h3>');
    $result = $connection->query('SELECT * FROM fruits');
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo('<div>id: ' . $row['id']. ' - name: ' . $row['name']. ', color ' . $row['color']. '</div>');
      }
    } else {
      echo("<p>No items in the database.</p>");
    }
    $connection->close();
} catch (\Exception $error) {
    var_dump($error);
}
?>

```

[**site.conf**](hello-php-apache/site.conf)

```apache
<VirtualHost *:80>
    ServerName hello-php-apache-from-scratch.local
    DocumentRoot /var/www/hello-php-apache-from-scratch/public

    <Directory "/var/www/hello-php-apache-from-scratch/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        <If "-f %{REQUEST_FILENAME}">
            SetHandler "proxy:unix:/var/run/php/php8.3-fpm.sock|fcgi://localhost"
        </If>
    </FilesMatch>
</VirtualHost>
```

#### Building image

`docker build -t hello-php-apache-from-scratch .`

* `build` - building a container
* `-t` tags an image with a name
* `hello-php-and-apache-from-scratch` - image name
* `.` - lets Docker know where it can find the Dockerfile

```console
$ docker build --no-cache -t hello-php-apache-from-scratch .
[+] Building 126.2s (12/12) FINISHED                                                                                                                                                                                                                               docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 497B                                                                                                                                                                                                                                         0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             0.7s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/7] FROM docker.io/library/ubuntu:latest@sha256:353675e2a41babd526e2b837d7ec780c2a05bca0164f7ea5dbbd433d21d166fc                                                                                                                                                0.0s
 => => resolve docker.io/library/ubuntu:latest@sha256:353675e2a41babd526e2b837d7ec780c2a05bca0164f7ea5dbbd433d21d166fc                                                                                                                                                       0.0s
 => [internal] load build context                                                                                                                                                                                                                                            0.0s
 => => transferring context: 96B                                                                                                                                                                                                                                             0.0s
 => [2/7] RUN apt update && apt upgrade -y     && apt install -y php8.3-fpm apache2 libapache2-mod-fcgid php8.3-mysql     && a2enmod proxy_fcgi && a2enconf php8.3-fpm                                                                                                     223.5s
 => [3/7] COPY site.conf /etc/apache2/sites-available/                                                                                                                                                                                                                       0.2s
 => [4/7] COPY index.php /var/www/hello-php-apache-from-scratch/public/                                                                                                                                                                                                      0.1s
 => [5/7] RUN a2dissite 000-default.conf && a2ensite site.conf                                                                                                                                                                                                               0.9s
 => [6/7] COPY start-services.sh /usr/local/bin/                                                                                                                                                                                                                             0.1s
 => [7/7] RUN chmod +x /usr/local/bin/start-services.sh                                                                                                                                                                                                                      0.7s
 => exporting to image                                                                                                                                                                                                                                                       7.7s
 => => exporting layers                                                                                                                                                                                                                                                      7.7s
 => => writing image sha256:0747084a6262cbedae46e8b4d6694428d335137809e5291550135f1ee752fa97                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/hello-php-apache-from-scratch                                                                                                                                                                                                             0.0s
```

```console
$ docker images
REPOSITORY                      TAG       IMAGE ID       CREATED         SIZE
hello-php-apache-from-scratch   latest    0747084a6262   5 minutes ago   355MB
hello-mysql-from-scratch        latest    32eae7d30853   2 hours ago     970MB
```

#### Creating container

`docker run -d -p 8080:80 --name hello-world-in-php-on-apache-from-scratch --network hello-php-apache-mysql hello-php-apache-from-scratch`

* `run` - running new container
* `-d` - detached mode (running in the background)
* `-p 8080:80` - mapping port 8080 on the Docker host to TCP port 80 in the container
* `--name hello-world-in-php-on-apache-from-scratch` - container name
* `--network hello-php-apache-mysql` - the network the container is connected to
* `hello-php-apache-from-scratch` - a particular local image

```console
$ docker run -d -p 8080:80 --name php-apache --network php-apache-and-mysql hello-php-and-apache
787c26fdb0e082a7d30e4763c5cff251d7e74ddb3b2292cc2d3b0d3f83ad3754
```

```console
$ docker ps -a
CONTAINER ID   IMAGE                           COMMAND                  CREATED          STATUS          PORTS                                         NAMES
d79382536b11   hello-php-apache-from-scratch   "/usr/local/bin/star…"   3 seconds ago    Up 3 seconds    0.0.0.0:8080->80/tcp, [::]:8080->80/tcp       hello-world-in-php-on-apache-from-scratch
ebee4d572a94   hello-mysql-from-scratch        "mysqld_safe"            38 minutes ago   Up 38 minutes   0.0.0.0:3307->3306/tcp, [::]:3307->3306/tcp   hello-world-with-mysql-from-scratch
```

#### Logging into container

`docker exec -it hello-world-in-php-on-apache-from-scratch /bin/bash`

* `exec` - execute command on the docker container
* `-it` - iteractive mode with terminal attached
* `hello-world-in-php-on-apache-from-scratch` - container name
* `/bin/bash` - the command

```console
$ docker exec -it hello-world-in-php-on-apache-from-scratch /bin/bash
root@2aa33d0b9525:/#
```

### Watching results

![Example application in browser](browser.png "Example application in browser")
