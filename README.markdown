# Things done

1.  Install apache/nginx
2.  Install PHP (and PHP-FPM for nginx)
3.  Uncommented MySQLi from /etc/php/php.ini if necessary
4.  Created user and database in MySQL

        grant all privileges to simple_php_app_db.* to 'simple_php_app'@'localhost' identified by 'password';
        create database simple_php_app_db;

5.  Set up dummy database and copy output with phpMyAdmin (you can import the *.sql files)
