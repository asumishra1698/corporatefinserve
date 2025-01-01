<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8ea2e71b3efa94a5ac49a6c8a8384caf
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8ea2e71b3efa94a5ac49a6c8a8384caf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8ea2e71b3efa94a5ac49a6c8a8384caf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8ea2e71b3efa94a5ac49a6c8a8384caf::$classMap;

        }, null, ClassLoader::class);
    }
}
