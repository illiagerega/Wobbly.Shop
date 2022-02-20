<?php
/**
 * Nikiforov
 * shop-nikiforov 2020
 */

namespace ishop\libs;


class TurboSMS
{
    private $token;
    private $sender;

    public function __construct($token, $sender)
    {
        if($token && $sender) {
            $this->token = $token;
            $this->sender = $sender;
        } else {
            throw new \Exception('No data');
        }
    }

    public function sendSMS($number, $text) {
        $json = json_encode([
            'recipients' => [
                $number
            ],
            'sms' => [
                'sender' => $this->sender,
                'text' => $text
            ]
        ]);

        $ch = curl_init( 'https://api.turbosms.ua/message/send.json' );
        # Setup request to send json via POST.
        $payload = $json;
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.$this->token));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}