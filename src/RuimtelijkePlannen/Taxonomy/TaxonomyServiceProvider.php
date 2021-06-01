<?php

namespace OWC\RuimtelijkePlannen\Taxonomy;

use OWC\RuimtelijkePlannen\Foundation\ServiceProvider;
use OWC\RuimtelijkePlannen\Traits\CheckPluginActive;

class TaxonomyServiceProvider extends ServiceProvider
{

    /**
     * the array of taxonomies definitions from the config
     *
     * @var array
     */
    protected $configTaxonomies = [];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
    }

    /**
     * Register custom taxonomies via extended_cpts.
     *
     * @return void
     */
    public function registerTaxonomies(): void
    {
        // If the openpub-base plugin is active there is no need to register taxonomies.
        if (!function_exists('register_extended_taxonomy') || CheckPluginActive::isPluginOpenPubBaseActive()) {
            return;
        }

        $this->configTaxonomies = $this->filterConfigTaxonomies();

        foreach ($this->configTaxonomies as $taxonomyName => $taxonomy) {
            // Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
            register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
        }
    }

    /**
     * Filter taxonomies based on plugin settings.
     *
     * @return array
     */
    protected function filterConfigTaxonomies(): array
    {
        if ($this->plugin->settings->useShowOn()) {
            return $this->plugin->config->get('taxonomies');
        }

        return array_filter($this->plugin->config->get('taxonomies'), function ($taxonomyKey) {
            return 'openpub-show-on' !== $taxonomyKey;
        }, ARRAY_FILTER_USE_KEY);
    }
}
