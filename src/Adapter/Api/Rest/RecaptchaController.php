<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\Recaptcha\RecaptchaFormUseCase;
use App\Core\Application\UseCase\Recaptcha\RecaptchaCheckUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class RecaptchaController
{
    private RecaptchaFormUseCase $recaptchaFormUseCase;
    private RecaptchaCheckUseCase $recaptchaCheckUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        RecaptchaFormUseCase $recaptchaFormUseCase,
        RecaptchaCheckUseCase $recaptchaCheckUseCase
    ) {
        $this->recaptchaFormUseCase = $recaptchaFormUseCase;
        $this->recaptchaCheckUseCase = $recaptchaCheckUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function recaptcha()
    {
        $this->recaptchaFormUseCase->execute();
    }

    public function recaptchaCheck()
    {
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $isHuman = $this->recaptchaCheckUseCase->execute($recaptchaResponse);
        $this->sendResponseController->sendResponse(['success' => $isHuman], 200);
    }
}