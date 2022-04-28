<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitaaebd3c677c3c10c45a07ab8d604f63a
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitaaebd3c677c3c10c45a07ab8d604f63a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitaaebd3c677c3c10c45a07ab8d604f63a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitaaebd3c677c3c10c45a07ab8d604f63a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
