<?php

namespace OWC\RuimtelijkePlannen\Tests\Base\PostType;

use Mockery as m;
use OWC\RuimtelijkePlannen\Foundation\Config;
use OWC\RuimtelijkePlannen\Foundation\Loader;
use OWC\RuimtelijkePlannen\Foundation\Plugin;
use OWC\RuimtelijkePlannen\PostType\PostTypeServiceProvider;
use OWC\RuimtelijkePlannen\Tests\TestCase;
use WP_Mock;

class PostTypeServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_spatial_plan_item_slug'    => '',
                '_owc_setting_openpub_enable_show_on'           => 0,
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_spatial_plan_item_slug'    => '',
                '_owc_setting_openpub_enable_show_on'           => 0,
            ]
        ]);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_posttypes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        // use function is_plugin_active
        \WP_Mock::userFunction('is_plugin_active', [
            'return' => true
        ]);

        $service = new PostTypeServiceProvider($plugin);

        $this->post     = m::mock(WP_Post::class);
        $this->post->ID = 1;

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'registerPostTypes',
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'pre_get_posts',
            $service,
            'orderByPublishedDate',
        ])->once();

        $service->register();

        $this->assertTrue(true);
    }
}
