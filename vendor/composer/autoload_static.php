<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf24519a1ba1c62a9cbbae34f0a5298f6
{
    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitf24519a1ba1c62a9cbbae34f0a5298f6::$classMap;

        }, null, ClassLoader::class);
    }
}