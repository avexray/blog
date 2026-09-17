<?php

require __DIR__ . '/../vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();
$compiler->setImportPaths('scss/');
$compiler->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);

$css = $compiler->compileFile('frontend/scss/main.scss')->getCss();

file_put_contents('public/style.css', $css);


