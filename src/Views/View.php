<?php

declare(strict_types=1);

namespace Altair\Views;

final class View
{
    private string $viewsPath;
    private array $data = [];

    public function __construct(string $viewsPath = '')
    {
        $this->viewsPath = $viewsPath ?: __DIR__ . '/../../views/';
    }

    public function render(string $view, array $data = []): string
    {
        $this->data = array_merge($this->data, $data);
        
        $viewFile = $this->viewsPath . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }

        // Extract data to variables
        extract($this->data);

        ob_start();
        include $viewFile;
        return ob_get_clean();
    }

    public function share(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function with(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public static function make(string $view, array $data = []): string
    {
        $instance = new self();
        return $instance->render($view, $data);
    }
}
