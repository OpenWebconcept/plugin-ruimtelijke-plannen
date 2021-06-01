<?php

namespace OWC\RuimtelijkePlannen\Tests\Base\Settings;

use OWC\RuimtelijkePlannen\Settings\SettingsPageOptions;
use OWC\RuimtelijkePlannen\Tests\TestCase;

class SettingsPageOptionsTest extends TestCase
{
    /** @var SettingsPageOptions */
    private $settingsPageOptions;

    public function setUp(): void
    {
        \WP_Mock::setUp();

        $this->settingsPageOptions = new SettingsPageOptions([
            '_owc_setting_portal_url'                       => 'https://www.test.nl',
            '_owc_setting_portal_spatial_plan_item_slug'    => 'zakelijke-besluiten',
            '_owc_setting_openpub_enable_show_on'           => false
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function portal_url_has_value(): void
    {
        $expectedResult = 'https://www.test.nl';
        $result         = $this->settingsPageOptions->getPortalURL();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_url_has_no_value(): void
    {
        $expectedResult = '';
        $result         = $this->settingsPageOptions->getPortalURL();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_value(): void
    {
        $expectedResult = 'zakelijke-besluiten';
        $result         = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_no_value(): void
    {
        $expectedResult = '';
        $result         = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function use_show_on_is_false()
    {
        $expectedResult = false;
        $result         = $this->settingsPageOptions->useShowOn();

        $this->assertEquals($expectedResult, $result);
    }
}
