<?php
use Pimple\Container;

$pimple = new Container();

//basic stuff
$pimple['request'] = function(Container $c)
{
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};

$pimple['router'] = function(Container $c)
{
    $routes = require __DIR__.'/routes.php';
    $router = \FastRoute\simpleDispatcher($routes);

    return $router;
};

$pimple['dispatchedRoute'] = $pimple->factory(function(Container $c){
    /** @var \FastRoute\Dispatcher $router */
    $router = $c['router'];
    /** @var \Symfony\Component\HttpFoundation\Request $request */
    $request = $c['request'];
    $routeInfo = $router->dispatch($request->getMethod(), $request->getRequestUri());

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            // ... 404 Not Found
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            // ... 405 Method Not Allowed
            break;
        case FastRoute\Dispatcher::FOUND:
            $controllerAction = $routeInfo[1];
            $vars = $routeInfo[2];

            $exploded = explode('::', $controllerAction);

            if (isset($c[$exploded[0]])){
                $controller = $c[$exploded[0]];
            }else{
                $controller = new $exploded[0];
            }
            
            return call_user_func_array([$controller, $exploded[1]], $vars);

            break;
    }
    
    return null;
});

//controllers

$pimple[App\Controllers\DependantController::class] = function(Container $c){
    return new \App\Controllers\DependantController($c['coolService']);
};

//services

$pimple['coolService'] = function(Container $c){
    return new \App\Services\SomeCoolService('Hello dependant world'); 
};

return $pimple;