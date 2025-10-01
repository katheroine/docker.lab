#!/bin/bash
service php8.3-fpm start
exec apachectl -D FOREGROUND
