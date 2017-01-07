#!/usr/bin/env bash

rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum install mod_php71w php71w-opcache
yum install php71w-cli php71w-common php71w-dba php71w-devel php71w-embedded php71w-fpm php71w-gd php71w-imap php71w-interbase php71w-intl php71w-mbstring php71w-mcrypt php71w-mysql php71w-odbc php71w-pdo php71w-pecl-redis php71w-tidy php71w-xml php71w-xmlrpc