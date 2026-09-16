<?php

namespace App\Renderers;

use Smarty\Smarty;

readonly class SmartyRenderer implements Renderer
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../../templates/');
        $this->smarty->setConfigDir(__DIR__ . '/../../config/');
        $this->smarty->setCompileDir(__DIR__ . '/../../runtime/compile/');
        $this->smarty->setCacheDir(__DIR__ . '/../../runtime/cache/');
    }

    public function view(string $template, ...$args): void
    {
        foreach ($args as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}