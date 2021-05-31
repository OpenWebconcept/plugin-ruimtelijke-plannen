<?php

return [
    'spatial_plans' => [
        'id'            => '_owc_spatial_plans_settings',
        'option_name'   => '_owc_spatial_plans_settings',
        'menu_title'    => __('Spatial plans', 'ruimtelijke-plannen'),
        'icon_url'      => 'dashicons-admin-settings',
        'position'      => 9,
        'parent'        => '_owc_openpub_base_settings',
        'submenu_title' => __('Spatial plans', 'ruimtelijke-plannen'),
        'columns'       => 1,
        'submit_button' => __('Save', 'ruimtelijke-plannen'),
        'tabs'          => [
            'spatial_plans' => __('Spatial plans', 'ruimtelijke-plannen'),
        ]
    ]
];
