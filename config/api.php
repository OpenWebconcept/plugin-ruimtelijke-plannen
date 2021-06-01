<?php

return [
    'models' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'ruimtelijkplan'   => [
            'fields' => [
                'related' => OWC\RuimtelijkePlannen\RestAPI\ItemFields\ConnectedField::class
            ],
        ]
    ],
];
