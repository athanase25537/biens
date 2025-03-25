<?php
namespace App\Controller;

use App\Srv\View\TwigView;

class HomeController {
    
    public function index(): void {
        // Instanciation de l'adaptateur Twig
        $twig = new TwigView();
        // Rendu du template 'home.html.twig' en passant des données (ici, le titre)
        $twig->render('home.html.twig');
    }

    public function login(): void 
    {
        $twig = new TwigView();
        $twig->render('login.html.twig');
    }

    public function not_found(): void 
    {
        $twig = new TwigView();
        $twig->render('404.html.twig');
    }
}
