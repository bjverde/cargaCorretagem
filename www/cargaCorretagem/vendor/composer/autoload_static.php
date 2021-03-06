<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3e5d844af8657025b3d52292ba5256a0
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vaites\\ApacheTika\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vaites\\ApacheTika\\' => 
        array (
            0 => __DIR__ . '/..' . '/vaites/php-apache-tika/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3e5d844af8657025b3d52292ba5256a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3e5d844af8657025b3d52292ba5256a0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
