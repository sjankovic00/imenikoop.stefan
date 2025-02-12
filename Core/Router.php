<?php
namespace Core;
class Router{
    protected $routes = [];
    public function add($method, $uri, $controller){
        $this->routes[]= [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller
        ];
        return $this;
    }
    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }
    public function route($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                [$controller, $method] = $route['controller'];
                $controller->$method();
                return;
            }
        }
        http_response_code(404);
        echo "404 - Stranica nije pronađena";
    }


}