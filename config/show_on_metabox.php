<?php

return [
    'show_on' => [
        'id'         => 'show_on',
        'title'      => __('External', 'ruimtelijke-plannen'),
        'post_types' => ['spatial_plan'],
        'context'    => 'normal',
        'priority'   => 'low',
        'autosave'   => true,
        'fields'     => [
            'settings' => [
                [
                    'name'       => __('Show on', 'ruimtelijke-plannen'),
                    'desc'       => __('Select websites where this item should be displayed on.', 'ruimtelijke-plannen'),
                    'id'         => 'show_on_active',
                    'type'       => 'taxonomy',
                    'taxonomy'   => 'openpub-show-on',
                    'field_type' => 'select_advanced',
                    'required'   => 1,
                    'multiple'   => 1
                ],
            ]
        ]
    ]
];
