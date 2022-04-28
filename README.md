# cms php 
> short links and url

# run migration
```bash
 #Create Database and table users,links
 php database/migrations.php
```

# example address api 

``` bash
 #login and register
 http://localhost/test/api/login/?username=abolfazl75&password=123456

#show links
http://localhost/test/api/show/link/.

#create link
 http://localhost/test/api/create/?url=https://www.youtube.com/watch.

#edit link
 http://localhost/test/api/edit/?id=5&url=https://dzone.com/articles/how-to-create-a-simple-and-efficient-php-cache&short=http://localhost/test/ffdDD87.

#delete link
 http://localhost/test/api/delete/?id=7
```
## create route
```bash
route("/test/api/create/", function () {
return 'test';
});

#dynamic route
route("/test/api/create/(.+)/?", function ($id, $data){
return [$id, $data];
});
```