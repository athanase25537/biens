<?php

namespace App\Core\Application\UseCase\Recaptcha;

class RecaptchaCheckUseCase
{
    private string $secretKey;
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function execute(string $recaptchaResponse): bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        if (isset($_POST['g-recaptcha-response'])) {
            $secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
            $response = $_POST['g-recaptcha-response'];
            $remoteIp = $_SERVER['REMOTE_ADDR'];
        
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$this->secretKey&response=$response&remoteip=$remoteIp";
            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);
        
            if ($responseKeys["success"]) {
                return true;
            } else {
                return false;
            }
        }
    }
}