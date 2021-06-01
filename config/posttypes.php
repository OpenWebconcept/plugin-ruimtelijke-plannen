<?php

return [
    /**
     * Examples of registering post types: https://johnbillion.com/extended-cpts/
     */
    'spatial_plan' => [
        'args' => [
            // Add the post type to the site's main RSS feed:
            'show_in_feed' => false,
            // Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],
            'public'        => true,
            'show_ui'       => true,
            'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments'],
            'menu_icon'     => 'dashicons-grid-view',
            'menu_position' => 6,
            'show_in_rest'  => true,
            'admin_cols'    => [
                'published' => [
                    'title'       => __('Published', 'ruimtelijke-plannen'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
                'orderby' => [],
            ],
            'labels' => [
                'singular_name'      => __('Spatial plan', 'ruimtelijke-plannen'),
                'menu_name'          => __('Spatial plans', 'ruimtelijke-plannen'),
                'name_admin_bar'     => __('New spatial plan', 'ruimtelijke-plannen'),
                'add_new'            => __('Add new spatial plan', 'ruimtelijke-plannen'),
                'add_new_item'       => __('Add spatial plan', 'ruimtelijke-plannen'),
                'new_item'           => __('New spatial plan', 'ruimtelijke-plannen'),
                'edit_item'          => __('Edit spatial plan', 'ruimtelijke-plannen'),
                'view_item'          => __('View spatial plan', 'ruimtelijke-plannen'),
                'all_items'          => __('All spatial plans', 'ruimtelijke-plannen'),
                'search_items'       => __('Search spatial plan', 'ruimtelijke-plannen'),
                'parent_item_colon'  => __('Parent spatial plan:', 'ruimtelijke-plannen'),
                'not_found'          => __('No spatial plans found.', 'ruimtelijke-plannen'),
                'not_found_in_trash' => __('No spatial plans found in trash.', 'ruimtelijke-plannen'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'spatial-plans',
            'singular' => __('Spatial plan', 'ruimtelijke-plannen'),
            'plural'   => __('Spatial plans', 'ruimtelijke-plannen'),
            'name'     => __('Spatial plans', 'ruimtelijke-plannen'),
        ],
    ],
];
