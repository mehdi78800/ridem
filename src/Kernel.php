<?php

namespace Ridem;

class Kernel
{

    public $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run($requestMethod, $uri)
    {
        $this->router->route($requestMethod, $uri);
    }
}
