<?php
namespace App\Middleware;

use App\Middleware\Contract\MiddlewareInterface;
use hisorange\BrowserDetect\Parser as Browser;

class BlockFirefox implements MiddlewareInterface{

    public function handel (){
        if (Browser::isFirefox()) {
            die('firefox was blocked');
        }
    }
}