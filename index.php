<?php

use App\Core\Routing\Router;

include 'bootsrap/init.php';
include 'vendor/autoload.php';



$route = new Router();
$route->run(); 


/* $route = '/post/{slug}';

$route_pattern = '/^\/post\/(?<slug>[-%\w]+)$/';
 */