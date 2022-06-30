<?php
namespace Bootstrap;

use App\Services\Web\Request;
use Providers\AppServiceProvider;

class App {
    public function __construct(
        public Request $request, 
        public AppServiceProvider $appServiceProvider
    ) {}

    static function handle(Request $request) {
        // Create the app service provider that will handle all the routing and app namespacing
        $app = new App($request, new AppServiceProvider());

        return $app->render();
    }

    public function render() {
        $route = $this->appServiceProvider->getRoute($this->request);
        
        $controller = new $route->controller;
        $controller->setTemplatingEngine($this->appServiceProvider->twig);
        return $controller->{$route->function}($this->request);
    }
}