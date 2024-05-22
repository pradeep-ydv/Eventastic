<?php

namespace App\Config;

class ViewRenderer
{
    protected $viewPath;

    public function __construct($viewPath)
    {
        $this->viewPath = rtrim($viewPath, '/');
    }

    public function setData(array $data, $context = 'raw')
    {
        // For simplicity, we're not using the context here
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

    public function render($view, $options = [], $saveData = false)
    {
        $viewFile = "{$this->viewPath}/{$view}.php";

        if (!file_exists($viewFile)) {
            throw new \Exception("View file {$viewFile} not found");
        }

        // Extract the variables to be used in the view
        extract(get_object_vars($this));

        // Start output buffering
        ob_start();
        include($viewFile);
        $output = ob_get_clean();

        return $output;
    }
}
