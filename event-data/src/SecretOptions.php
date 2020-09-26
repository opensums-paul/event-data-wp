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

use EventData\WpPlugin\OptionsGroup;

class SecretOptions extends OptionsGroup {
    protected $keys = [
        'ticket-tailor-api-key' => [],
    ];

}
