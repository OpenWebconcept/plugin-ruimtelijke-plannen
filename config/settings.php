<?php

return [
    'spatial_plans'  => [
        'id'             => 'spatial_plans',
        'title'          => __('Spatial plans', 'ruimtelijke-plannen'),
        'settings_pages' => '_owc_spatial_plans_settings',
        'tab'            => 'spatial_plans',
        'fields'         => [
            'settings' => [
                'settings_spatial_plans_portal_url' => [
                    'name' => __('Portal URL', 'ruimtelijke-plannen'),
                    'desc' => __('URL including http(s)://', 'ruimtelijke-plannen'),
                    'id'   => 'setting_portal_url',
                    'type' => 'text',
                ],
                'settings_spatial_plans_slug' => [
                    'name' => __('Portal spatial plans item slug', 'ruimtelijke-plannen'),
                    'desc' => __('URL for spatial plans items in the portal, eg "ruimtelijk-plan"', 'ruimtelijke-plannen'),
                    'id'   => 'setting_portal_spatial_plan_item_slug',
                    'type' => 'text',
                ],
                'openpub_enable_show_on' => [
                    'name' => __('Show on', 'ruimtelijke-plannen'),
                    'desc' => __('Used for configuring on which websites an openpub-item should be displayed on.', 'ruimtelijke-plannen'),
                    'id'   => 'setting_openpub_enable_show_on',
                    'type' => 'checkbox'
                ]
            ],
        ]
    ]
];
