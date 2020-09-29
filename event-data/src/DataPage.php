<?php
/**
 * This file is part of the API Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/api-data-wp
 * @package   event-data-wp
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

declare(strict_types=1);

namespace EventData;

use EventData\WpPlugin\AdminPage;

/**
 */
class DataPage extends AdminPage {

    // Autoload these on admin pages.
    protected $assets = [
        [ 'style', 'tabulator-css', 'tabulator.min.css' ],
        [ 'script', 'tabulator', 'tabulator.min.js' ],
        [ 'script', 'event-data', 'event-data.js' ],
        // [ 'script', 'wp-api', null ],
    ];

    // protected $capability = 'event_data_view_data';

    // Add a new menu section.
    protected $menuParent = null;

    protected $pageSlug = 'data';

    protected $pageTitle = 'Event Data';

    protected $template = 'admin/data-page';

    protected function prepare(): array {
        $api = $this->container->get('ticket-tailor');
        return [
            'data' => $api->getEvents(),
            'tickets' => $api->getEventTickets('ev_410363'),
        ];
    }
}
