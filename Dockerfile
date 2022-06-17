FROM amazonlinux:2

# install nginx
RUN amazon-linux-extras install php7.3 nginx1

RUN yum -y update
RUN yum -y install file zip \
    && yum -y install php-mbstring php-intl php-xml php-gd php-pear php-devel gcc make \
    && yum clean all \
    && rm -rf /var/cache/yum

RUN pecl install xdebug

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN curl -sL https://rpm.nodesource.com/setup_14.x | bash -
RUN yum install nodejs -y

# Config for PHP
COPY nginx/php.ini /etc/

## change uid, gid for apache
RUN usermod -u 1000 apache && groupmod -g 1000 apache
RUN chown apache:apache /var/lib/php/session

# Config for nginx
COPY nginx/conf.d/server.conf /etc/nginx/conf.d/ 
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# SSL for nginx
RUN openssl req -x509 -sha256 -nodes -days 3650 -newkey rsa:2048 -subj /CN=localhost -keyout localhost.key -out localhost.crt
RUN cp -p localhost.crt /etc/nginx/localhost.crt
RUN cp -p localhost.key /etc/nginx/localhost.key

EXPOSE 443 80

COPY startup.sh /startup.sh
RUN chmod 744 /startup.sh
CMD ["/startup.sh"]
