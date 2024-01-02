<?php

use App\Core\Request;

define('BASEPATH',__DIR__ . '/../');

include BASEPATH . 'vendor/autoload.php';
include BASEPATH . 'helpers/helpers.php';
$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();


$request = new Request();

include BASEPATH . 'routes/web.php';