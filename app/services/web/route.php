<?php
namespace App\Services\Web;

class Route {
    public function __construct(public string $method, public string $controller, public string $function)
    {}

    static function get(string $controller, string $function) {
        return new Route("GET", $controller, $function);
    }

    static function post(string $controller, string $function) {
        return new Route("POST", $controller, $function);
    }
}