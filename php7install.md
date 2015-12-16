安装:
sudo apt-get update
sudo apt-get install libxml2-dev


安装gcc
sudo apt-get  install  build-essential


sudo apt-get install openssl 
sudo apt-get install libssl-dev 
apt-get install make
apt-get install curl
apt-get install libcurl4-gnutls-dev


sudo apt-get install libjpeg-dev
sudo apt-get install libfreetype6-dev
//根据实际的情况查看是否有包的存在

sudo apt-get install libpng-dev


sudo apt-get install libmcrypt-dev


sudo apt-get install libreadline6 libreadline6-dev


cd php-7*


3. 编译
./configure


./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc --enable-fpm --with-fpm-user=www --with-fpm-group=www --with-mysqli --with-pdo-mysql --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-mbstring --with-mcrypt --enable-ftp --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-gettext --disable-fileinfo --enable-maintainer-zts  






./configure --prefix=/usr/local/php --enable-fpm --enable-inline-optimization --disable-debug --disable-rpath --enable-shared --enable-opcache  --with-mysql --with-mysqli --with-mysql-sock  --enable-pdo --with-pdo-mysql --with-gettext --enable-mbstring --with-iconv --with-mcrypt --with-mhash --with-openssl --enable-bcmath --enable-soap --with-libxml-dir --enable-pcntl --enable-shmop --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-sockets --with-curl --with-zlib --enable-zip --enable-bz2 --with-readline --without-sqlite3 --without-pdo-sqlite --with-pear --with-libdir=/lib/x86_64-linux-gnu --with-gd --with-jpeg-dir=/usr/lib --enable-gd-native-ttf --enable-xml










#安装 PHP
 make && make test
 make && sudo make install


下面是对php-fpm运行用户进行设置
 配置php-fpm


cd /usr/local/php/etc


cp php-fpm.conf.default php-fpm.conf


vim php-fpm.conf


修改
user = www-data
 group = www-data


如果www-data用户不存在，那么先添加www-data用户
groupadd www-data
 useradd -g www-data www-data




启动php-fpm


sudo /usr/local/php/sbin/php-fpm
