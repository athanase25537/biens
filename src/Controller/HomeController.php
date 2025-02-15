<?php
namespace App\Controller;

use App\Srv\View\TwigView;

class HomeController {
    public function index(): void {
        // Instanciation de l'adaptateur Twig
        $twig = new TwigView();
        // Rendu du template 'home.html.twig' en passant des données (ici, le titre)
        $twig->render('home.html.twig', [
            'title' => 'Accueil - BailOnline'
        ]);
    }
}
