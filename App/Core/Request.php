<?php
namespace App\Core;

class Request{

    private $param;
    private $route_params;
    private $method;
    private $agent;
    private $ip;
    private $uri;

    public function __construct()
    {
        $this->param = $_REQUEST;
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function add_route_param($key, $value)
    {
        $this->route_params = [$key => $value];
    }
    public function get_route_param($key)
    {
        return $this->route_params = [$key];
    }
    public function get_route_params()
    {
        return $this->route_params;
    }

    public function param()
    {
        return $this->param;
    }

    public function agent()
    {
        return $this->agent;
    }

    public function method()
    {
        return $this->method;
    }

    public function ip()
    {
        return $this->ip;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function input($key)
    {
        return $this->param[$key] ?? null;
    }

    public function isset($key)
    {
        return isset( $this->param[$key]);
    }

    public function redirect($path)
    {
        header('Location:'.site_url($path));
        die();
    }


    
    
}