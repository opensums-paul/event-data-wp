<?php
/**
 * This file is part of the Event Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/event-data-wp
 * @package   event-data-wp/ticket-tailor
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

declare(strict_types=1);

namespace EventData\TicketTailor;

class Api {
    /** @var Container Dependencies. */
    protected $container; 

    /** @var mixed[] Settings. */
    protected $settings;

    /** @var string API URL. */
    protected $url = 'https://api.tickettailor.com/v1';

    public function __construct($container) {
        $this->container = $container;
        $wp = $container->get('wp');
        $secrets = $wp->getOption('event_data_secrets');
        $this->settings = [
            'api-key' => $secrets['ticket-tailor-api-key'],
        ];
    }

    /**
     * Get a collection of events.
     */
    public function getEvents() {
        $data = $this->apiRequest('/events');
        return [
            'events' => $data['data'],
        ];
    }

    /**
     * Get a collection of tickets for an event.
     */
    public function getEventTickets($eventId) {
        $data = $this->apiRequest("/issued_tickets?event_id=$eventId");
        return [
            'tickets' => $data['data'],
        ];
    }

    protected function apiRequest($path) {
        return $this->container->get('wp')->jsonRequest([
            'url' => $this->url,
            'path' => $path,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->settings['api-key']),
            ]
        ]);
    }
}
