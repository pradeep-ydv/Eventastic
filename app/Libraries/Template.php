<?php

namespace App\Libraries;

class Template
{
    public array $templateData = [];

    public function set(string $contentArea, mixed $value): void
    {
        $this->templateData[$contentArea] = $value;
    }

    public function render(string $template = '', string $name = '', string $view = '', array $viewData = [], bool $return = false): void
    {
        $this->set($name, view($view, $viewData));

        echo view($template, $this->templateData);
    }
}
