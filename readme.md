Geo Ip Test
=============================

By default the config file (\config\Api.php) has the option
 "ApiStatus" set to “1”,  this works as an on/off 
 button for the endpoint to work. 
 While the first  database update it should
  be set to “0” for the api to show 
  updating database code message.

##Installation

##It  will be needed
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
DB_CONNECTION=mysql
DB_HOST=<your DB Host>
DB_PORT=3306
DB_DATABASE=<your database name>
DB_USERNAME=<your database username>
DB_PASSWORD=<your database password>
```


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
phpunit
```

##Usage
the ip goes in the end of the Url it is possible to insert there other 

YOURSERVER_ADRESS/locationByIP/81.0.3.202

##Comments 
Why i choosed the Crontab approach?
It allows to update with determined periocity the table without having to show the maintenance page.

Why Laravel ?
There is no reason except for curiosity and learning purposes.
