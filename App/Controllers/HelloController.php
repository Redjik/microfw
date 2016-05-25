<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function index()
    {
        return Response::create('Hello World');
    }
}