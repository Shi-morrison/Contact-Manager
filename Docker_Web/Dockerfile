FROM php:8.1.23-apache
RUN apt update

# needed for some mysqli stuff in php
RUN docker-php-ext-install mysqli pdo pdo_mysql 