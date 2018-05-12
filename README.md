Management AWS Application 
==========================
The "Management AWS Application" is a application created to monitor the different project developed by the U-PRO Team

Requirements
------------
  * PHP 7.1.3 or higher
  * NPM

Installation
------------
Execute this command to install the project:
```
composer install
```
Load data fixtures to your database.
```
php bin/console doctrine:fixtures:load
```
Usage
-----
```
php bin/console server:run
```


Useful commands
---------------

```
 yarn run encore dev
 yarn run encore dev --watch
 yarn run encore production
 ```