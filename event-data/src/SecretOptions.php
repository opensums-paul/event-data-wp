<?php

declare(strict_types=1);

namespace EventData;

use EventData\WpPlugin\OptionsGroup;

class SecretOptions extends OptionsGroup {
    protected $keys = [
        'ticket-tailor-api-key' => [],
    ];

}
