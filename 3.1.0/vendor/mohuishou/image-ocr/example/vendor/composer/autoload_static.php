<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit575e3130b14578f8c7e3e370ddc9af27
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mohuishou\\ImageOCR\\Example\\' => 27,
            'Mohuishou\\ImageOCR\\' => 19,
            'Minho\\Captcha\\' => 14,
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mohuishou\\ImageOCR\\Example\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Mohuishou\\ImageOCR\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../src',
        ),
        'Minho\\Captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/lifei6671/php-captcha/src',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit575e3130b14578f8c7e3e370ddc9af27::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit575e3130b14578f8c7e3e370ddc9af27::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}