<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0dabf51485c17910d99e5a88c66a2ed6
{
    public static $files = array (
        '2c102faa651ef8ea5874edb585946bce' => __DIR__ . '/..' . '/swiftmailer/swiftmailer/lib/swift_required.php',
    );

    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'ishop\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'R' => 
        array (
            'RedBeanPHP\\' => 11,
        ),
        'L' => 
        array (
            'LisDev\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ishop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ishop/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
        'LisDev\\' => 
        array (
            0 => __DIR__ . '/..' . '/lis-dev/nova-poshta-api-2/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'V' => 
        array (
            'Valitron' => 
            array (
                0 => __DIR__ . '/..' . '/vlucas/valitron/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0dabf51485c17910d99e5a88c66a2ed6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0dabf51485c17910d99e5a88c66a2ed6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit0dabf51485c17910d99e5a88c66a2ed6::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
