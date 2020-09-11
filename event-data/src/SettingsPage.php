<?php

/**
 * This file is part of the API Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/api-data-wp
 * @package   api-data
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

namespace EventData;

use EventData\WpPlugin\AdminPage;

/**
 */
class SettingsPage extends AdminPage {

    /** @var string The parent for the entry in the Admin menu. */
    protected $menuParent = 'settings';

    /** @var string The name of the template to render. */
    protected $template = 'admin/settings-page';

    // Refactor after here, ideally into the parent ----------------------------

    protected function loadAdminPage(): void {
        $this->adminPage = new AdminPage($this->plugin, [
            'template' => 'admin/settings-page',
            'sectionTemplate' => 'admin/settings-page-sections',
            'menuParent' => 'settings',
            // 'pageTitle' => 'TT (Ticket Tailor) Plus'
        ]);

        $this->adminPage->addSections([
            // placeholder
            // helper to the right
            // supplemental underneath
            [
                // This is prefixed and used as the key in the wp_options table.
                'group' => 'user-settings',
                // Prefixed and used as the section element's id.
                'id' => 'user-settings',
                'title' => __('Ticket Tailor settings', 'tt-plus'),
                'fields' => [
                    /*
                    [
                        // An html field.
                        'id' => 'current-default',
                        'label' => __('Current default set', 'tt-plus'),
                        'type' => 'html',
                        'html' => '<div>Just some HTML</div>',
                    ],
                    [
                        // A select field.
                        'id' => 'default-flag-set',
                        'label' => __('Change default set', 'tt-plus'),
                        'type' => 'select',
                        'options' => [
                            'key1' => 'value1',
                        ],
                    ],
                    [
                        // A textarea field.
                        'id' => 'api-key2',
                        'label' => __('API Key', 'tt-plus'),
                        'type' => 'textarea',
                        'placeholder' => 'PH',
                        'rows' => 1,
                    ],
                    */
                    [
                        // A text field.
                        'id' => 'api-key',
                        'label' => __('API Key', 'tt-plus'),
                        'type' => 'text',
                        'placeholder' => 'API Key',
                        'size' => 48,
                    ],
                ],
            ],
        ]);
    }
}
