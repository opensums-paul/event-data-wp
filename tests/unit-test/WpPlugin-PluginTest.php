<?php

namespace Tests\EventData\WpPlugin;

use EventData\WpPlugin\Plugin;

use WP_Mock;
use WP_Mock\Tools\TestCase;

require __DIR__.'/fixtures/TestPlugin.php';

class PluginTest extends TestCase {
    public function setUp(): void {
        WP_Mock::setUp();
    }

    public function tearDown(): void {
        WP_Mock::tearDown();
    }

    public function testAPluginCanBeCreated(): void {
        $plugin = new TestPlugin();

        $this->assertInstanceOf(Plugin::class, $plugin);
    }

    public function testPluginGetName(): void {
        $plugin = new TestPlugin();

        $this->assertEquals('Test Plugin', $plugin->getName());
    }

    public function testPluginGetVersion(): void {
        $plugin = new TestPlugin();

        $this->assertEquals('0.0.0-dev', $plugin->getVersion());
    }

    public function testPluginSlugifyWithNoArguments(): void {
        $plugin = new TestPlugin();

        $this->assertEquals('test-plugin', $plugin->slugify());
    }

    public function testPluginSlugifyWithArguments(): void {
        $plugin = new TestPlugin();

        $this->assertEquals('test_plugin_core_settings', $plugin->slugify('core-settings', '_'));
    }
}
