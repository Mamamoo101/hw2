FROM php:8.2-apache

RUN apt-get update

RUN docker-php-ext-install mysqli 
RUN docker-php-ext-enable mysqli