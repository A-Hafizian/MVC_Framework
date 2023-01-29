<?php

use App\Core\Routing\Router;
use App\Models\users;

include 'bootsrap/init.php';
include 'vendor/autoload.php';

//my_varDump($request).PHP_EOL;

$user = new users();
my_varDump($user->get(['name'], []));


$route = new Router();
$route->run(); 



/* $route = '/post/{slug}';

$route_pattern = '/^\/post\/(?<slug>[-%\w]+)$/';
 */