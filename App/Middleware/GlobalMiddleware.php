<?php
namespace App\Middleware;

use App\Middleware\Contract\MiddlewareInterface;
use hisorange\BrowserDetect\Parser as Browser;


class GlobalMiddleware implements MiddlewareInterface{
    public function handel()
    {
        $this->FireFoxBlock();
        $this->sanitizeGetParams();        
    }
    public function FireFoxBlock()
    {
        if (Browser::isFirefox()) {
            die('firefox was blocked');
        } 

    }
    public function sanitizeGetParams()
    {
        foreach ($_GET as $key => $value) {
            $_GET[$key] = xss_clean($value);
        }
    }
}
