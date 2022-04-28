## folder config 
file database.php

## folder database
class db.php connection database 
##and
file migrations.php create database and table

[ run migrations ] ==> php database/migrations.php


## address api 

-- [login and register] http://localhost/test/api/login/?username=abolfazl75&password=123456

-- [show links] http://localhost/test/api/show/link/.

-- [create link] http://localhost/test/api/create/?url=https://www.youtube.com/watch.

-- [edit link] http://localhost/test/api/edit/?id=5&url=https://dzone.com/articles/how-to-create-a-simple-and-efficient-php-cache&short=http://localhost/test/ffdDD87.

-- [delete link] http://localhost/test/api/delete/?id=7

## create route

route("/test/api/create/", function () {
return 'test';
});

dynamic route

route("/test/api/create/(.+)/?", function (){
return 'test';
});