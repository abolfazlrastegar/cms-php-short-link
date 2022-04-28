<?php
require_once "routes/router.php";

$link = new \App\Controllers\linkController();
//link
route('test/api/show/link', function () use ($link) {
    return $link->index();
});

route("/test/api/edit/(.+)/?", function () use ($link) {
    return $link->edit();
});

route("/test/api/create/(.+)/?", function () use ($link) {
    return $link->createLink();
});

route("/test/api/delete/(.+)/?", function () use ($link) {
    return $link->delete();
});


//login
$login = new \App\Controllers\AuthController();
route("test/api/login/(.+)/?", function () use ($login) {
    $login->login();
});

route("test/404", function () {
    return 'not login user';
});

dispatch($_SERVER['REQUEST_URI']);