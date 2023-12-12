<?php
class Autoloader
{
    public static function registrate(string $dir): void
    {
        $autoload = function (string $classname) use ($dir) {
            $path = str_replace('\\', '/', $classname);
            $path = $dir . "/" . $path . ".php";

            if (file_exists($path)) {
                require_once $path;
            }
        };
        spl_autoload_register($autoload);
    }
}