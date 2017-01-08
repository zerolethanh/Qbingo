#!/usr/bin/env bash

#install
yum -y install httpd

#start & enable apache
systemctl start httpd
systemctl enable httpd

#firewall
firewall-cmd --add-service=http --permanent
firewall-cmd --reload

# edit http config
#vi /etc/httpd/conf/httpd.conf