<?php

namespace OWC\RuimtelijkePlannen\Expiration;

use OWC\RuimtelijkePlannen\Foundation\ServiceProvider;

class ExpirationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addAction('updated_post_meta', new ExpirationController(), 'afterMetaUpdate', 10, 4);
    }
}
