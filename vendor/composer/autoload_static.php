<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitda9112784a3f6f3936f1a77c952a3bb5
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitda9112784a3f6f3936f1a77c952a3bb5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitda9112784a3f6f3936f1a77c952a3bb5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitda9112784a3f6f3936f1a77c952a3bb5::$classMap;

        }, null, ClassLoader::class);
    }
}
