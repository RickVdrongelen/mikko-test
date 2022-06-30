<?php
namespace Providers;

use App\Services\Web\Request;

class AppServiceProvider {
    public array $routes = [];
    public \Twig\Environment $twig;

    public function __construct() {
        $this->routes = include_once(__DIR__.'/../routes/web.php');

        $loader = new \Twig\Loader\FilesystemLoader("../app/views");
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../cache/view_cache'
        ]);
    }

    public function getRoute(Request $request) {
        return $this->routes[$request->endpoint];
    }
}