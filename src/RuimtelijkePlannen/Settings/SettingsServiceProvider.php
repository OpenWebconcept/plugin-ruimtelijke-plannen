<?php

namespace OWC\RuimtelijkePlannen\Settings;

use OWC\RuimtelijkePlannen\Metabox\MetaboxBaseServiceProvider;
use OWC\RuimtelijkePlannen\Traits\CheckPluginActive;

class SettingsServiceProvider extends MetaboxBaseServiceProvider
{
    const PREFIX = '_owc_';

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->plugin->loader->addFilter('mb_settings_pages', $this, 'registerSettingsPage', 10, 1);
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerSettings', 10, 1);
    }

    /**
     * @param $rwmbSettingsPages
     *
     * @return array
     */
    public function registerSettingsPage($rwmbSettingsPages): array
    {
        $settingsPages = $this->plugin->config->get('settings_pages');

        if (!CheckPluginActive::isPluginOpenPubBaseActive()) {
            // unset the parent of the setting page.
            unset($settingsPages['spatial_plans']['parent']);
        }

        return array_merge($rwmbSettingsPages, $settingsPages);
    }

    /**
     * Register metaboxes for settings page.
     *
     * @param $rwmbMetaboxes
     *
     * @return array
     */
    public function registerSettings($rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('settings');
        $metaboxes       = [];

        if (CheckPluginActive::isPluginOpenPubBaseActive()) {
            // unset setting because it is already defined in the openpub base plugin.
            unset($configMetaboxes['spatial_plans']['fields']['settings']['settings_spatial_plans_portal_url']);
        }

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, $metaboxes);
    }
}
