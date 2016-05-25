<?php
return function(FastRoute\RouteCollector $r){

    $r->addRoute('GET', '/hello', App\Controllers\HelloController::class.'::index');

    $r->addRoute('GET', '/di', App\Controllers\DependantController::class.'::test');







};