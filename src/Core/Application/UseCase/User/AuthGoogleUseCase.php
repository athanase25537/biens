<?php

namespace App\Core\Application\UseCase\User;
use App\Port\In\User\AuthGoogleInputPort;

class AuthGoogleUseCase implements AuthGoogleInputPort
{
    private $login_url;

    public function __construct($client)
    {
        $this->login_url = $client->createAuthUrl();
    }

    public function connect() 
    {
        echo '
            <a href="'.$this->login_url.'">Se connecter avec Google</a>';
    }

    public function checkLogin()
    {
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $oauth = new Google_Service_Oauth2($client);
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