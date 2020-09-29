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

namespace EventData;

use EventData\WpPlugin\Container;

/**
 * This class implements WordPress REST API routes.
 */
class Routes {

    /** @var string WordPress capability for 'root' level permissions. */
    protected $rootPermission = 'manage_options';

    /** @var string Path prefix for all ticket tailor routes. */
    protected $routeNamespace = 'event-data/v1';

    /**
     * Constructor.
     *
     * @param Container $container Dependencies.
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * Register routes with the WP REST dispatcher.
     */
    public function register() {
        $this->registerRoute([
            'path' => '/ticket-tailor/event/(?P<id>[A-Za-z0-9_-]+)/tickets',
            'callback' => function ($params) {
                $api = $this->container->get('ticket-tailor');
                $payload = $api->getEventTickets($params['id']);
                return new \WP_REST_Response($payload, 200);
            },
        ]);

        $this->registerRoute([
            'path' => '/ticket-tailor/events',
            'callback' => function () {
                $api = $this->container->get('ticket-tailor');
                $payload = $api->getEvents();
                return new \WP_REST_Response($payload, 200);
            },
        ]);

    }

    protected function checkPermission(string $permission = null): bool {
        if ($permission === null) {
            return current_user_can($this->rootPermission);
        }
        return current_user_can($permission) || current_user_can($this->rootPermission);
    }

    protected function registerRoute(array $route) {
        register_rest_route($this->routeNamespace, $route['path'], [
            'methods' => 'GET',
            'callback' => $route['callback'],
            'permission_callback' => function () use ($route) {
                return $this->checkPermission($route['permission'] ?? null);
            },
        ]);
    }
}
