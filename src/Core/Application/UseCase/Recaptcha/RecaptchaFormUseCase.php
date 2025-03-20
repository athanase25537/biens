<?php

namespace App\Core\Application\UseCase\Recaptcha;

class RecaptchaFormUseCase
{
    private string $siteKey;   
    public function __construct(string $siteKey)
    {
        $this->siteKey = $siteKey;
    }

    public function execute(): void
    {
        ?>
        <html>
    <head>
        <title>reCAPTCHA demo: Simple page</title>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <form action="/api/recaptcha-check" method="POST">
        <div class="g-recaptcha" data-sitekey="<?= $this->siteKey ?>"></div>
        <br/>
        <input type="submit" value="Submit">
        </form>
    </body>
    </html>
        <?php
    }
}
?>