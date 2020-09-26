<?php

namespace EventData\TicketTailor;
/*
$headers = array(
    'Accept' => 'application/json',
    'Authorization' => 'Basic ' . base64_encode(API_KEY),
    // 'Authorization' => 'Basic sk_289_86336_98dfaca44861239330cccdae1dd1582f:',
);
$request_body = [];
$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.tickettailor.com/']);
// Define array of request body. $request_body = array();
try {
    $response = $client->request('GET','/v1/orders', array(
        'headers' => $headers,
        'json' => $request_body,
      )
    );
    header('Content-Type: application/json');
    print_r($response->getBody()->getContents());
} catch (\GuzzleHttp\Exception\BadResponseException $e) {
    // handle exception or api errors.
    print_r($e->getMessage());
}
*/

class Api {
    protected $settings;

    protected $url = 'https://api.tickettailor.com';

    protected static $instance;

    public function __construct($settings) {
        $this->settings = $settings;
        self::$instance = $this;
    }

    public static function instance() {
        return self::$instance;
    }

    public function getEvents() {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->settings['api-key']),
        ];
        $req = wp_remote_get("$this->url/v1/events", [
            'headers' => $headers,
        ]);
        if (wp_remote_retrieve_response_code($req) !== 200) {
            return [
                [
                    'error' => $req,
                ],
            ];
        }
        $data = json_decode(wp_remote_retrieve_body($req), true);
        return [
            'events' => $data['data'],
        ];
    }

    public function getEventTickets($eventId) {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->settings['api-key']),
        ];
        $req = wp_remote_get("$this->url/v1/issued_tickets?event_id=$eventId", [
            'headers' => $headers,
        ]);
        if (wp_remote_retrieve_response_code($req) !== 200) {
            return [
                [
                    'error' => $req,
                ],
            ];
        }
        $data = json_decode(wp_remote_retrieve_body($req), true);
        return [
            'events' => $data['data'],
        ];
    }
}
