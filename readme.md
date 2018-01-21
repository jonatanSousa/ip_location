Geo Ip Test
=============================

###configuration
By default, the config file (\config\Api.php) has the option
 "ApiStatus" set to “1”,  this works as an on/off 
 button for the endpoint to work. 
 During the first database update it should
  be set to “0” for the api to show 
  updating database code message.

###Installation

###The server must have:
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

To populate the database use this console command which can be later used as cron job to update the table periodically.  
```
php artisan command:populateGeoIpDB
```


##Unit Testing 

Unit tests are using , there for, it should be installed, to run them make sure "Norway" was already inserted in the 
table if not there will an assertion which will give an error.

```
phpunit
```

##Usage
the ip goes in the end of the Url it is possible to insert other 

YOURSERVER_ADRESS/locationByIP/81.0.3.202

The endpoint should give a msg as bellow
```
{"id":1,"min_ip_range":"1.0.0.0","max_ip_range":"1.0.0.255","min_int_ip":16777216,"max_int_ip":16777471,"country_code":"AU","country_name":"Australia","created_at":"2018-01-20 17:00:45","updated_at":"2018-01-20 23:14:20"}
```

##Comments 
###Why i choosed the Crontab approach?
It allows to update with determined periodicity the table without having down time.

###Why Laravel ?
There is no reason except for curiosity and learning purposes.
