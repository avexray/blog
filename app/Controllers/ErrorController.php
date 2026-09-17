<?php

namespace App\Controllers;

class ErrorController extends Controller
{
    public function error(string $message, int $code): void
    {
        http_response_code($code);
        $this->renderer->view('error.tpl', [
            'code' => $code,
            'message' => $message
        ]);
    }
}