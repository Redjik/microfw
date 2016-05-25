<?php

require __DIR__.'/../vendor/autoload.php';


/** @var \Pimple\Container $pimple */
$pimple = require __DIR__.'/../config/di.php';
$result = $pimple->offsetGet('dispatchedRoute');

if ($result instanceof \Symfony\Component\HttpFoundation\Response){
    $result->send();
}else{
    echo $result;
}