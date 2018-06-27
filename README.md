# CakePHP-JWT
Post URL:- 

Live Demo:- https://cake_jwt.trinitytuts.com/

This is a sample CakePHP 3 project in which we can Implement ACL and JWT to make or web application more secure. You can clone this project in your desktop and follow below simple steps to run this in your local server.

## Installation

Open terminal and clone this project using below command

```sh
git clone https://github.com/anehkumar/CakePHP-JWT.git
```
Import "CakePHP-JWT/db/cakeJwt.sql" file to your database from cloned project
Now configure your database in "config/app.php" file, here one have to enter username, password and database details
Open your project "localhost/CakePHP-JWT" in browser. if displaying errors of permission type "chown -Rf www-data.www-data /var/www/html/" in terminal.
From terminal type "cd CakePHP-JWT" and run aco synchronisation command by typing "bin/cake acl_extras aco_sync".
Set permission of auth component to add new user without login in UsersController.php file.

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/ba72c816d4dd09bf796f)
