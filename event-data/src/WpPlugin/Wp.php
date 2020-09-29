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

    public function jsonRequest(array $request = []) {
        $headers = array_merge(
            [
                'Accept' => 'application/json',
            ],
            $request['headers']
        );
        $url = ($request['url'] ?? '') . ($request['path'] ?? '/');
        $req = wp_remote_get($url, [ 'headers' => $headers ]);
        if (wp_remote_retrieve_response_code($req) !== 200) {
            return [
                [
                    'error' => $req,
                ],
            ];
        }
        return json_decode(wp_remote_retrieve_body($req), true);
    }
}
