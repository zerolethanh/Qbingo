#!/usr/bin/env bash

#install rpm
rpm -Uvh https://dev.mysql.com/get/mysql57-community-release-el7-9.noarch.rpm
yum -y install mysql-community-server

# enable mysql
systemctl enable mysqld
systemctl start mysqld

# get password
sudo cat /var/log/mysqld.log | grep 'temporary password'

#change password
mysql_secure_installation

# enable firewall
firewall-cmd --add-service=mysql --permanent
firewall-cmd --reload


#CREATE USER 'lvt'@'%' IDENTIFIED BY 'password';
#GRANT ALL PRIVILEGES ON *.* TO 'lvt'@'%' WITH GRANT OPTION;