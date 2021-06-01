<?php

namespace OWC\RuimtelijkePlannen\Settings;

use OWC\RuimtelijkePlannen\Traits\CheckPluginActive;

class SettingsPageOptions
{
    /**
     * Settings defined on settings page.
     *
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * URL to the portal website.
     *
     * @return string
     */
    public function getPortalURL(): string
    {
        return $this->settings['_owc_setting_portal_url'] ?? '';
    }

    public function getPortalItemSlug(): string
    {
        return $this->settings['_owc_setting_portal_spatial_plan_item_slug'] ?? '';
    }

    public function useShowOn(): bool
    {
        return $this->settings['_owc_setting_openpub_enable_show_on'] ?? false;
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                    => '',
            '_owc_setting_portal_spatial_plan_item_slug' => '',
            '_owc_setting_openpub_enable_show_on'        => false
        ];

        $options = get_option('_owc_spatial_plans_settings', []);

        if (CheckPluginActive::isPluginOpenPubBaseActive()) {
            // include openpub-base settings.
            $options = array_merge($options, get_option('_owc_openpub_base_settings', []));
        };

        return new static(wp_parse_args($options, $defaultSettings));
    }
}
