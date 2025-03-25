<?php

namespace App\Core\Application\UseCase\User;
use App\Port\In\User\AuthGoogleInputPort;

class AuthGoogleUseCase implements AuthGoogleInputPort
{
  
    private $login_url;
    private $client;

    public function __construct($client)
    {
        $this->login_url = $client->createAuthUrl();
        $this->client = $client;
    }

    public function connect() 
    {
        return header('Location: ' . $this->login_url);
    }

    public function checkLogin()
    {
        if (isset($_GET['code'])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->client->setAccessToken($token);

            $oauth = new \Google_Service_Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();

            $_SESSION['user'] = [
                'id' => $userInfo->id,
                'name' => $userInfo->name,
                'email' => $userInfo->email,
                'picture' => $userInfo->picture
            ];

            return [
                "status" => 200,
                "message" => "success"
            ];
        }

        return [
            "status" => 400,
            "message" => "failed"
        ];

    }
}