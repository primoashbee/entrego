https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-laravel-with-nginx-on-ubuntu-22-04#step-3-creating-a-new-laravel-application
Installation

ssh 

sudo apt-get update
sudo apt install php-mbstring php-xml php-bcmath

sudo mysql
sudo mysql

CREATE DATABASE entrego;
CREATE USER 'userentrego'@'%' IDENTIFIED WITH mysql_native_password BY '!3Nt3G0d3v3l0p';

GRANT ALL ON userentrego.* TO 'userentrego'@'%';
exit;


mysql -u userentrego -p
verify connection



install all pkgs, composer, etc*

composer install
mkdir /var/www/entrego
sudo mv ~/entrego /var/www/entrego

permissions

sudo chown -R www-data.www-data /var/www/entrego/storage
sudo chown -R www-data.www-data /var/www/entrego/bootstrap/cache


sudo vim /etc/nginx/sites-available/entrego


server {
    listen 80;
    server_name 167.99.76.249;
    root /var/www/entrego/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

activate vhost
sudo


https://www.linkedin.com/pulse/organized-steps-deploy-laravel-app-ec2-instance-2204-selvanantham/

188.166.222.247

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'd3v3l0p';

nginx no ssl
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/html/entrego/public/;

    client_max_body_size 0;

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}