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

    public function biens(): void
    {
        if(!$this->is_connected()) {
            $this->redirect_to_template('login.html.twig', ['error' => 'Vous devez vous connecter pour accéder à cette page.']);
            return;
        }

        $baseUrl = "http://localhost";
        $url = $baseUrl . "/api/bien-immobilier/get-all/0";
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);;
        $biens = $data['message']['bien_immobilier'];
        $twig = new TwigView();
        $twig->render('bien.html.twig', ['biens' => $biens]);
    }

    public function displayBien($bien_id): void 
    {
        if(!$this->is_connected()) {
            $this->redirect_to_template('login.html.twig', ['error' => 'Vous devez vous connecter pour accéder à cette page.']);
            return;
        }

        $baseUrl = "http://localhost";
        $url = $baseUrl . "/api/bien-immobilier/get-bien-by-id/".$bien_id;

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $data = $data['message']['bien_immobilier'];
        $twig = new TwigView();
        $twig->render('display_bien.html.twig', ['data' => $data]);
    }
    

    public function dump_array($array): void 
    {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }

    public function logout(): void 
    {
        session_start();
        session_destroy();
        header("Location: /");
        exit();
    }

    public function is_connected(): bool 
    {
        if(!isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public function redirect_to_template($template, $data = []): void 
    {
        $twig = new TwigView();
        $twig->render($template, $data);
    }
}
