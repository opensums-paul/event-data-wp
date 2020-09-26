<?php
/**
 * This file is part of the Event Data plugin for WordPress™.
 *
 * @link      https://github.com/opensums/event-data-wp
 * @package   event-data-wp/wp-plugin
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

declare(strict_types=1);

namespace EventData\WpPlugin;

class Wp {
    public function getOption(string $key, $default = null) {
        return get_option($key, $default);
    }
}
