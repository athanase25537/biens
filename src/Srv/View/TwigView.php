<?php
namespace App\Srv\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigView {
    private $twig;

    public function __construct() {
        // Définir le chemin vers le dossier des templates
        $loader = new FilesystemLoader('/var/www/html/src/Srv/templates');

        // Configurer l'environnement Twig
        $this->twig = new Environment($loader, [
            // Pour la production, vous pouvez activer le cache (ex. 'cache' => __DIR__ . '/../../cache/twig')
            'cache' => false,
            'debug' => true,
        ]);
    }

    /**
     * Rendu du template Twig avec les données fournies.
     *
     * @param string $template Nom du template (ex: 'home.html.twig')
     * @param array  $data     Données à transmettre au template
     */
    public function render(string $template, array $data = []): void {
        echo $this->twig->render($template, $data);
    }
}
