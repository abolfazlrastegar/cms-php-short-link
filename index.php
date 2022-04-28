<?php
require_once realpath('vendor/autoload.php');

if (PHP_VERSION >= "8.1.4") {
    require_once realpath('routes/api.php');
}
echo 'version php platform 8.1.4  ' . ' php =' . PHP_VERSION;







