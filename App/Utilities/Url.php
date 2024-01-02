<?php

namespace App\Utilities;

class Url {
    public static function currnt_route(){
        return strtok($_SERVER['REQUEST_URI'], '?');
    }


    public static function views_Url(){
        return __DIR__ .'/../../views/';
    }
}
