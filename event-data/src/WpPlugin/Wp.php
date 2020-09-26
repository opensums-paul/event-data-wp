<?php

namespace EventData\WpPlugin;

class Wp {
    public function getOption(string $key, $default = null) {
        return get_option($key, $default);
    }
}
