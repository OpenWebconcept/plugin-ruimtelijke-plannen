<?php

return [
    'spatial_plans' => [
        'id'         => 'spatial_plans_metadata',
        'title'      => __('Data', 'ruimtelijke-plannen'),
        'post_types' => ['spatial_plan'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'general'   => [
                'expiration' => [
                    'name'       => __('Expiration date', 'ruimtelijke-plannen'),
                    'desc'       => __("The default value of this field is set to a date four weeks from now. The value of this field is only saved when the status of this post is set to 'publish'. If the post status, after saving, is not 'publish' the value will be cleared.", 'ruimtelijke-plannen'),
                    'id'         => 'spatial_plans_expiration_date',
                    'type'       => 'datetime',
                    'js_options' => [
                        'dateFormat'      => 'dd-mm-yy',
                        'showTimepicker'  => true,
                    ],
                    'save_format' => 'Y-m-d H:i:s',
                    'std'         => (new \DateTime('now', new DateTimeZone('Europe/Amsterdam')))->modify('+4 week')->format('d-m-Y H:i')
                ]
            ]
        ]
    ],
];
