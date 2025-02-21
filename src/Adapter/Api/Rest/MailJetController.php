<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\MailJet\MailJetUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class MailJetController
{

    private MailJetUseCase $mailJetUseCase;
    private SendResponseController $sendResponseController;
    public function __construct(MailJetUseCase $mailJetUseCase)
    {
        $this->mailJetUseCase = $mailJetUseCase;
        $this->sendResponseController = new SendResponseController();
    }
	

    public function sendMessage()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $response = $this->mailJetUseCase->send($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        $this->sendResponseController::sendResponse($response, 201);
    }

}