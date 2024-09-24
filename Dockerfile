FROM hasancansahan/php-fpm
    WORKDIR /var/www/html
    COPY . .
    RUN rm -f .env && mv .env.docker .env
    
