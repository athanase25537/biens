<?php

namespace App\Port\In\MailJet;

use \Mailjet\Resources;

Interface MailJetInputPort
{
    public function send(array $data): ?array;
}
