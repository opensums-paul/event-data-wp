<?php

/**
 * This file is part of the API Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/api-data-wp
 * @package   event-data-wp
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

namespace EventData;

use EventData\WpPlugin\AdminPage;

/**
 */
class DataPage extends AdminPage {

    protected $assets = [
        [ 'style', 'tabulator-css', 'tabulator.min.css' ],
        [ 'script', 'tabulator', 'tabulator.min.js' ],
    ];

    // protected $capability = 'event_data_view_data';

    // Add a new menu section.
    protected $menuParent = null;

    protected $pageSlug = 'data';

    protected $pageTitle = 'Event Data';

    protected $template = 'admin/data-page';
}
