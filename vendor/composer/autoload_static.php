<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb8ee8487993a3b35ba70608b60308a7
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb8ee8487993a3b35ba70608b60308a7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb8ee8487993a3b35ba70608b60308a7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteb8ee8487993a3b35ba70608b60308a7::$classMap;

        }, null, ClassLoader::class);
    }
}
