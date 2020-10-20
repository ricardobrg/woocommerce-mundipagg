<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf1c05886241b8116f6b1e3527e54dd07
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'apimatic\\jsonmapper\\' => 20,
        ),
        'W' => 
        array (
            'WC_MundiPagg\\' => 13,
        ),
        'M' => 
        array (
            'MundiAPILib\\' => 12,
        ),
        'A' => 
        array (
            'Automattic\\Jetpack\\Autoloader\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'apimatic\\jsonmapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/jsonmapper/src',
        ),
        'WC_MundiPagg\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/WC_MundiPagg',
        ),
        'MundiAPILib\\' => 
        array (
            0 => __DIR__ . '/..' . '/mundipagg/mundiapi/src',
        ),
        'Automattic\\Jetpack\\Autoloader\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Unirest\\' => 
            array (
                0 => __DIR__ . '/..' . '/apimatic/unirest-php/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf1c05886241b8116f6b1e3527e54dd07::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf1c05886241b8116f6b1e3527e54dd07::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitf1c05886241b8116f6b1e3527e54dd07::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
