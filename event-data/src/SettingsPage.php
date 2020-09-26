<?php
/**
 * This file is part of the Event Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/event-data-wp
 * @package   event-data-wp
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

declare(strict_types=1);

namespace EventData;

use EventData\WpPlugin\AdminPage;

/**
 */
class SettingsPage extends AdminPage {

    protected $menuParent = 'event-data-data';

    protected $menuLabel = 'Event Data Settings';

    protected $pageSlug = 'settings';

    // protected $sectionsTemplate = 'admin/settings-page-sections';
    protected $template = 'admin/settings-page';
}
