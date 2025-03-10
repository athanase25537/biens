<?php

namespace App\Core\Application\UseCase\MailJet;

use App\Port\In\MailJet\MailJetInputPort;
use \Mailjet\Resources;
use \Mailjet\Client;

class MailJetUseCase implements MailJetInputPort
{
    private Client $mailJet;
    public function __construct(string $apiKey, string $secretKey)
    {
        $this->mailJet = new Client($apiKey, $secretKey, true, ['version' => 'v3.1']);
    }
    public function send(array $data): ?array
    {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $data['sender_mail'],
                        'Name' => $data['sender_name']
                    ],
                    'To' => [
                        [
                            'Email' => $data['receiver_mail'],
                            'Name' => $data['receiver_name']
                        ]
                    ],
                    'Subject' => $data['subject'],
                    'TextPart' => $data['text_part'],
                    'HTMLPart' => $data['html_part']
                ]
            ]
        ];

        $response = $this->mailJet->post(Resources::$Email, ['body' => $body]);
        return $response->success() ? $response->getData() : null;

        /*
         * 
         * For debug
         * 
         * return $response->success() ? $response->getData() : [
         *   * 'error' => $response->getReasonPhrase(),
         *   * 'status' => $response->getStatus(),
         *   * 'body' => $response->getBody()
         * ];
         * 
        */
    }
}
