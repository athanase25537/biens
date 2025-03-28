<?php
namespace App\Srv\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class TwigView {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader('/var/www/html/src/Srv/templates');

        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);

        // Use the core DebugExtension instead
        $this->twig->addExtension(new DebugExtension());
    }

    public function render(string $template, array $data = []): void {
        echo $this->twig->render($template, $data);
    }
}