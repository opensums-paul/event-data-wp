<?php
/**
 * This file is part of API Data plugin for WordPress.
 *
 * @package    api-data-wp
 * @copyright  2020 OpenSums
 * @license    MIT
 */

namespace EventData;

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 */
class Plugin extends WpPlugin\Plugin {
    // --- YOU MUST OVERRIDE THESE IN THE PLUGIN CLASS -------------------------

    /** @var string Plugin human name. */
    protected $name = 'Event Data';

    /** @var string Plugin slug (aka text domain). */
    protected $slug = 'event-data';

    /** @var string Current version. */
    protected $version = '0.1.0-dev';

    /** @var string[] Admin page class names. */
    protected $adminPages = [
        DataPage::class,
        SettingsPage::class,
        SecretsPage::class,
    ];

    /** @var string[] Option groups. */
    protected $optionsGroups = [
        'options' => Options::class,
        'secrets' => SecretOptions::class,
    ];
    // -------------------------------------------------------------------------
};
