<?php

namespace App\Renderers;

interface Renderer
{
    public function view(string $template, ...$args);
}

