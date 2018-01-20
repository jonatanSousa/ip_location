Geo Ip Test
=============================

##Installation

Requirements:
- Appache
- Composer 
- PHP 7 or higher
- Mysql 5.5 or higher   

Clone the repository to a configured webserver.

```
git clone https://github.com/jonatanSousa/ip_location.git
```

This project  uses composer as dependency manager in the root directory install it, 
following the instrustions on https://getcomposer.org/doc/00-intro.md


After downloading composer execute this command:
```
composer install
```

At the the project root path and make a **.env.example** file a copy named **.env**.

Change the following parameters:

```
. . .

APP_URL=http://<your URL, could be localhost>

DB_CONNECTION=mysql
DB_HOST=<your DB Host>
DB_PORT=3306
DB_DATABASE=<your database name>
DB_USERNAME=<your database username>
DB_PASSWORD=<your database password>


To create the table execute this command on the project directory 
```
php artisan migrate
```

To populate the database there this console task which can be later used as cron job to update the table periodicly 

```
php artisan command:populateGeoIpDB
```


##Unit Testing 

Unit tests are using Guzzle there for it should be instaled with this comand 
```
composer update
```