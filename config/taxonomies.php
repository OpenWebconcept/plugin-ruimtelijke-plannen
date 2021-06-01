<?php

return [
    'openpub-show-on' => [
        'object_types' => ['spatial_plan'],
        'args'         => [
            'show_in_rest'      => false,
            'show_admin_column' => true,
            'capabilities'      => [
                'manage_terms' => 'manage_options',
                'edit_terms' => 'manage_options',
                'delete_terms' => 'manage_options',
                'assign_terms' => 'manage_categories'
            ]
        ],
        'names'        => [
            'singular' => __('Show on', 'ruimtelijke-plannen'),
            'plural'   => __('Show on', 'ruimtelijke-plannen')
        ]
    ]
];
