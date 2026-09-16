<?php

namespace App\Controllers;

use App\Renderers\Renderer;

abstract class Controller
{
    protected readonly Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
}