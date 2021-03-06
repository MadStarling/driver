<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit927eea052a223a2ce507961f9b574804
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Utilities\\' => 10,
        ),
        'P' => 
        array (
            'Politics\\' => 9,
        ),
        'O' => 
        array (
            'Obj\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Utilities\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/utilities',
        ),
        'Politics\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/politics',
        ),
        'Obj\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/obj',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit927eea052a223a2ce507961f9b574804::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit927eea052a223a2ce507961f9b574804::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
