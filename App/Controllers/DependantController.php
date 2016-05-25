<?php


namespace App\Controllers;


use App\Services\SomeCoolService;
use Symfony\Component\HttpFoundation\Response;

class DependantController
{
    /**
     * @var SomeCoolService
     */
    private $service;

    public function __construct(SomeCoolService $service)
    {
        $this->service = $service;
    }
    
    public function test()
    {
        return Response::create($this->service->getData());
    }
}