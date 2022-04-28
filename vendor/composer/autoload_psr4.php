<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Test\\DevCoder\\' => array($vendorDir . '/devcoder-xyz/php-router/tests'),
    'Psr\\Http\\Server\\' => array($vendorDir . '/psr/http-server-handler/src', $vendorDir . '/psr/http-server-middleware/src'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-factory/src', $vendorDir . '/psr/http-message/src'),
    'DevCoder\\' => array($vendorDir . '/devcoder-xyz/php-router/src'),
    'Database\\' => array($baseDir . '/database'),
    'App\\' => array($baseDir . '/app'),
);