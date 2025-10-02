# Example: Hello World web application in PHP on Apache with MySQL from scratch

## Multi-container

### Configuring MySQL image

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

### Configuring PHP & Apache image

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

### Creating multicontainer

#### Preparing compose.yaml

[**compose.yaml**](compose.yaml)

```yaml
name: hello-world-in-php-on-apache-with-mysql-from-scratch

services:

  php-apache:
    container_name: hello-world-in-php-on-apache-from-scratch
    build:
      context: hello-php-apache/
    ports:
      - "8080:80"

  mysql:
    container_name: hello-world-with-mysql-from-scratch
    build:
      context: hello-mysql/
    ports:
      - "3307:3306"

```

#### Running multi-container

`docker compose up -d`

* `compose` - manage multi-container
* `up` - creating and starting multi-container
* `-d` - detached mode (running in the background)

```bash
$ docker compose up -d
Compose can now delegate builds to bake for better performance.
 To do so, set COMPOSE_BAKE=true.
[+] Building 190.0s (23/23) FINISHED                                                                                                                                                                                                                               docker:default
 => [php-apache internal] load build definition from Dockerfile                                                                                                                                                                                                              0.0s
 => => transferring dockerfile: 510B                                                                                                                                                                                                                                         0.0s
 => [mysql internal] load build definition from Dockerfile                                                                                                                                                                                                                   0.0s
 => => transferring dockerfile: 380B                                                                                                                                                                                                                                         0.0s
 => [mysql internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                       2.2s
 => [php-apache auth] library/ubuntu:pull token for registry-1.docker.io                                                                                                                                                                                                     0.0s
 => [php-apache internal] load .dockerignore                                                                                                                                                                                                                                 0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => [mysql internal] load .dockerignore                                                                                                                                                                                                                                      0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => [mysql 1/5] FROM docker.io/library/ubuntu:latest@sha256:fdb6c9ceb1293dcb0b7eda5df195b15303b01857d7b10f98489e7691d20aa2a1                                                                                                                                                 7.7s
 => => resolve docker.io/library/ubuntu:latest@sha256:fdb6c9ceb1293dcb0b7eda5df195b15303b01857d7b10f98489e7691d20aa2a1                                                                                                                                                       0.0s
 => => sha256:78281ac7684a7caf02348780a1b5de85844548a3cc0505df924de98380a0eeea 424B / 424B                                                                                                                                                                                   0.0s
 => => sha256:ce8f79aecc435fc0b22d4dd58c72836e330beddf204491eef3f91af51bc48ed7 2.30kB / 2.30kB                                                                                                                                                                               0.0s
 => => sha256:a1a21c96bc16121569dd937bcd1c745a5081629b3b08a664446602ded91e10a4 29.72MB / 29.72MB                                                                                                                                                                             3.6s
 => => sha256:fdb6c9ceb1293dcb0b7eda5df195b15303b01857d7b10f98489e7691d20aa2a1 6.69kB / 6.69kB                                                                                                                                                                               0.0s
 => => extracting sha256:a1a21c96bc16121569dd937bcd1c745a5081629b3b08a664446602ded91e10a4                                                                                                                                                                                    3.6s
 => [php-apache internal] load build context                                                                                                                                                                                                                                 0.0s
 => => transferring context: 1.47kB                                                                                                                                                                                                                                          0.0s
 => [mysql internal] load build context                                                                                                                                                                                                                                      0.0s
 => => transferring context: 34B                                                                                                                                                                                                                                             0.0s
 => [mysql 2/5] RUN apt update && apt upgrade -y     && apt install -y mysql-server-8.0                                                                                                                                                                                    124.4s
 => [php-apache 2/7] RUN apt update && apt upgrade -y     && apt install -y php8.3-fpm apache2 libapache2-mod-fcgid php8.3-mysql     && a2enmod proxy_fcgi && a2enconf php8.3-fpm                                                                                          169.6s
 => [mysql 3/5] RUN sed -i "s|bind-address  = 127.0.0.1|#bind-address  = 127.0.0.1 |g" /etc/mysql/mysql.conf.d/mysqld.cnf                                                                                                                                                    1.0s
 => [mysql 4/5] COPY database.sql /var/tmp/                                                                                                                                                                                                                                  0.2s
 => [mysql 5/5] RUN service mysql start     && echo "source /var/tmp/database.sql" | mysql                                                                                                                                                                                   6.0s
 => [mysql] exporting to image                                                                                                                                                                                                                                              20.2s
 => => exporting layers                                                                                                                                                                                                                                                     20.2s
 => => writing image sha256:36c3357e4eead9855bfa7f4f77d7b6477fb1bb6f2684bf95986c57e35275a785                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/hello-world-in-php-on-apache-with-mysql-from-scratch-mysql                                                                                                                                                                                0.0s
 => [mysql] resolving provenance for metadata file                                                                                                                                                                                                                           0.1s
 => [php-apache 3/7] COPY site.conf /etc/apache2/sites-available/                                                                                                                                                                                                            0.2s
 => [php-apache 4/7] COPY index.php /var/www/hello-php-apache-from-scratch/public/                                                                                                                                                                                           0.1s
 => [php-apache 5/7] RUN a2dissite 000-default.conf && a2ensite site.conf                                                                                                                                                                                                    1.0s
 => [php-apache 6/7] COPY start-services.sh /usr/local/bin/                                                                                                                                                                                                                  0.2s
 => [php-apache 7/7] RUN chmod +x /usr/local/bin/start-services.sh                                                                                                                                                                                                           0.7s
 => [php-apache] exporting to image                                                                                                                                                                                                                                          8.0s
 => => exporting layers                                                                                                                                                                                                                                                      8.0s
 => => writing image sha256:ea4895943d800655e21b6789ad8840eb2535c22f5d019d6b3c689966117bf12f                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/hello-world-in-php-on-apache-with-mysql-from-scratch-php-apache                                                                                                                                                                           0.0s
 => [php-apache] resolving provenance for metadata file                                                                                                                                                                                                                      0.0s
[+] Running 5/5
 ✔ mysql                                                                 Built                                                                                                                                                                                               0.0s
 ✔ php-apache                                                            Built                                                                                                                                                                                               0.0s
 ✔ Network hello-world-in-php-on-apache-with-mysql-from-scratch_default  Created                                                                                                                                                                                             0.2s
 ✔ Container hello-world-in-php-on-apache-from-scratch                   Started                                                                                                                                                                                             1.4s
 ✔ Container hello-world-with-mysql-from-scratch                         Started                                                                                                                                                                                             1.3s
```

```console
$ docker network ls
NETWORK ID     NAME                                                           DRIVER    SCOPE
c294fa0eb3b6   bridge                                                         bridge    local
5876f77e76b5   hello-world-in-php-on-apache-with-mysql-from-scratch_default   bridge    local
e7d6d7973119   host                                                           host      local
f3babe8fdced   none                                                           null      local
```

```console
$ docker image ls
REPOSITORY                                                        TAG       IMAGE ID       CREATED         SIZE
hello-world-in-php-on-apache-with-mysql-from-scratch-php-apache   latest    ea4895943d80   3 minutes ago   338MB
hello-world-in-php-on-apache-with-mysql-from-scratch-mysql        latest    36c3357e4eea   4 minutes ago   952MB
```

```console
$ docker container ls -a
CONTAINER ID   IMAGE                                                             COMMAND                  CREATED         STATUS         PORTS                                         NAMES
21e2cbf840c3   hello-world-in-php-on-apache-with-mysql-from-scratch-php-apache   "/usr/local/bin/star…"   3 minutes ago   Up 3 minutes   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp       hello-world-in-php-on-apache-from-scratch
7fd32cbc8acb   hello-world-in-php-on-apache-with-mysql-from-scratch-mysql        "mysqld_safe"            3 minutes ago   Up 3 minutes   0.0.0.0:3307->3306/tcp, [::]:3307->3306/tcp   hello-world-with-mysql-from-scratch
```

### Watching results

![Example application in browser](browser.png "Example application in browser")
