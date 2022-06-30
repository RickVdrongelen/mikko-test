<?php
namespace App\Services\Web;

class Request {
    public function __construct(public string $endpoint, private array $input, private array $query) {}

    static function capture() {
        return new Request(strtok($_SERVER['REQUEST_URI'], '?'), $_REQUEST, $_GET);
    }

    public function formInput() : array {
        return $this->input;
    }

    public function getQuery() {
        return $this->query;
    }    
}