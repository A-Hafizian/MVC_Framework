<?php

namespace App\Core\Routing;

use App\Core\Request;
use App\Core\Routing\Route;
use Exception;

class Router
{
    private $request;
    private $routes;
    private $current_route;

    const BASE_CONTROLLER = '\App\Controllers\\';
    const GLOBAL_MIDDLEWARE = '\App\Middleware\GlobalMiddleware';
    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Route::routes();
        $this->current_route = $this->findRoute($this->request) ?? null;
        //r($this->request->method());
        #run middleware here
        $this->run_route_middleware();
    }
    private function run_route_middleware()
    {
        #run global Middleware 

        if (!class_exists(self::GLOBAL_MIDDLEWARE)) {
            throw new \Exception("Class " . self::GLOBAL_MIDDLEWARE . " not exists");
        }
        $globalMiddleware = self::GLOBAL_MIDDLEWARE;
        $globalMiddlwareObject = new $globalMiddleware;
        $globalMiddlwareObject->handel();

        $middleware = $this->current_route['middleware'] ?? [];
        foreach ($middleware as $middlewareClass) {
            $middleware_object = new $middlewareClass();
            $middleware_object->handel();
        }
    }
    public function findRoute(Request $request)
    {
        //echo $request->method() . "___" . $request->uri();
        foreach ($this->routes as $route) {
            if (!$this->invalidRequest($route)) {
                continue;
            }
            if ($this->regex_matched($route)) {
                return $route;
            }
            
        }
        return null;
    }
    public function regex_matched($route)
    {
        global $request;
        $pattern = '/^' . str_replace(['/', '{', '}'], ['\/', '(?<', '>[-%\w]+)'], $route['uri']) . '$/';
        $result = preg_match($pattern,$this->request->uri(), $matches);

        if (!$result) {
            return false;
        }
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $request->add_route_param($key, $value);
            }
        }
        return true;
    }
    public function invalidRequest($route)
    {
        if (!in_array($this->request->method(), $route["methods"])) {
            return false;
        }
        return true;
    } 
    public function dispatch405()
    {
        header("HTTP/1.0 405 Method Not Allowed");
        view('errors.405');
        die();
    }
    public function dispatch404()
    {
        header('HTTP/1.0 404 Not Found');
        view('errors.404');
        die();
    }


    public function run()
    {
        # 404 : uri not exists
        if (is_null($this->current_route)) {
            $this->dispatch404();
        }
        #405 : Method Invalid request
        if (!$this->current_route) {
            $this->dispatch405();
        }

        $this->dispatch($this->current_route);
    }
    private function dispatch($route)
    {
        $action = $route['action'];


        #action : null
        if (is_null($action) || empty($action)) {
            return;
        }

        #action : clousure
        if (is_callable($action)) {
            $action();
        }

        #action : controller@method
        if (is_string($action)) {
            $action = explode('@', $action);
        }

        #action : ['controller','method']
        if (is_array($action)) {
            $className = self::BASE_CONTROLLER . $action[0];
            $method = $action[1];
            if (!class_exists($className)) {
                throw new \Exception("Class $className not exists");
            }
            $controller = new $className();
            if (!method_exists($controller, $method)) {
                throw new \Exception("Method $method not exists in Class $className");
            }
            $controller->$method();
        }
    }
}
