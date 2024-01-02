<?php

use App\Core\Routing\Route;
use App\Middleware\BlockFirefox;

Route::add(['get','post'],'/a',['HomeController','Hi'],[BlockFirefox::class]);

Route::get('/b',function (){
    echo "b";
}); 

Route::get('/post/{slug}');

Route::put('/c',function (){
    echo "c";
}); 
Route::get('/ali',function (){
    echo "salam";
}); 

