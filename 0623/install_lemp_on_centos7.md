#### How to install LEMP stack on CentOS 7

**1. Update yum and install necessary utils  **
```shell
sudo yum update
# Install yum-utils packages tool
sudo yum install yum-utils

# Install telnet
sudo yum install telnet -y

# Install nc tool
sudo yum install nc -y

# Install screen tool  
sudo yum install screen

# Install vim
sudo yum install vim

```

**2. Install EPEL repository**
```
sudo yum install epel-release -y

```

**3. Install nginx **
```

# Reference nginx official http://nginx.org/en/linux_packages.html#RHEL-CentOS
# To set up the yum repository, create the file named /etc/yum.repos.d/nginx.repo with the following contents:
sudo vim /etc/yum.repos.d/nginx.repo
----------
name=nginx stable repo
baseurl=http://nginx.org/packages/centos/$releasever/$basearch/
gpgcheck=1
enabled=1
gpgkey=https://nginx.org/keys/nginx_signing.key

[nginx-mainline]
name=nginx mainline repo
baseurl=http://nginx.org/packages/mainline/centos/$releasever/$basearch/
gpgcheck=1
enabled=0
gpgkey=https://nginx.org/keys/nginx_signing.key

----------

# Enable default nginx stable packages
sudo yum-config-manager --enable nginx-mainline

# start install nginx
sudo yum install nginx -y

```

** 4.Install mysql5.7**
```
# Yum mysqlrepository https://dev.mysql.com/downloads/repo/yum/

cd ~
wget https://dev.mysql.com/get/mysql57-community-release-el7-9.noarch.rpm

# install package
sudo rpm -ivh mysql57-community-release-el7-9.noarch.rpm
sudo yum install mysql-server -y

# start mysqld
sudo systemctl start mysqld


# temporary password is generated for the MySQL root user. Locate it in the mysqld.log

sudo grep 'temporary password' /var/log/mysqld.log

# copy it like this
d:%y?g647j*V

# configuring mysql Enter a new 12-character password that contains at least one uppercase letter, one lowercase latter, one number and one special character.
Reference digitalocean tutorial
https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-centos-7
# exmaple:xxx@mysql2019

sudo mysql_secure_installation







```

**5. Install php on CentOS **
```
# Install Remi repository
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm


# Enable remi repo, run:
sudo yum-config-manager --enable remi-php72
sudo yum update

# Install php7.2 on centOS
sudo yum install php72 -y

# Install php-fpm and commonly used modules
sudo yum install php72-php-fpm php72-php-gd php72-php-json php72-php-mbstring php72-php-mysqlnd php72-php-xml php72-php-xmlrpc php72-php-opcache php72-curl php72-dev php72-openssl php72-redis php72-bcmatch -y

# Create php command link
sudo ln -s /usr/bin/php72 /usr/bin/php

# Enable php72-fpm service
sudo systemctl enable php72-php-fpm.service

# start php fpm service
sudo systemctl start php72-php-fpm.service
```

**6. Configure nginx for using with php7.2**

```
# find ngins server user and group names
egrep '^(user|group)' /etc/nginx/nginx.conf

# Edit vim /etc/opt/remi/php72/php-fpm.d/www.conf set user and group to nginx
sudo vim /etc/opt/remi/php72/php-fpm.d/www.conf

# changed Like this
user = nginx
group = nginx

# saved and close the file restart php-fpm service
sudo systemctl restart php72-php-fpm.service


```

**7. update nginx config**
```
# update your nginx config
sudo vim /etc/nginx/conf.d/default.conf

----------
server {
    listen       80;
    server_name  server_domain_name_or_IP;

    # note that these lines are originally from the "location /" block
    root   /usr/share/nginx/html;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }
    error_page 404 /404.html;
    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /usr/share/nginx/html;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
----------

# Restart nginx
sudo systemctl restart nginx

# Test php processing on your web server
sudo vim /usr/share/nginx/html/info.php

# wirte test script
<?php phpinfo(); ?>

# open address you want to visit will be:
# open in a web brwoser:
http://your_server_IP_address/info.php


```


**Configure firewalld to Allow nginx traffic**
```
sudo firewall-cmd --zone=public --permanent --add-service=http
sudo firewall-cmd --zone=public --permanent --add-service=https
sudo firewall-cmd --reload

```
