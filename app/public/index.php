<?php

use Core\App;
use Core\Autoloader;
use Core\Container;

require_once '../Autoloader.php';
Autoloader::registrate(dirname(__DIR__));

require_once '../Config/dependencies.php';
require_once '../Config/routes.php';

$container = depend(new Container());

$app = routes(new App(), $container);

$app->run();
