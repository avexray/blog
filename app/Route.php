<?php

namespace App;

class Route
{
    private readonly string $_httpPath;
    private readonly string $_httpMethod;

    private readonly string $_controller;
    private readonly string $_function;

    public function __construct(string $httpPath, string $httpMethod, string $controller, string $function)
    {
        $this->_httpPath = $httpPath;
        $this->_httpMethod = $httpMethod;

        $this->_controller = $controller;
        $this->_function = $function;
    }

    public function invoke(): void
    {
        $controllerName = $this->getController();
        $functionName = $this->getFunction();

        (new $controllerName)->$functionName();
    }

    public function getHttpPath(): string
    {
        return $this->_httpPath;
    }

    function getHttpMethod(): string
    {
        return $this->_httpMethod;
    }

    public function getController(): string
    {
        return $this->_controller;
    }

    public function getFunction(): string
    {
        return $this->_function;
    }
}