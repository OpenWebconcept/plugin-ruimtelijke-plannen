<?php

namespace OWC\RuimtelijkePlannen\Repositories;

use OWC\RuimtelijkePlannen\Models\RuimtelijkPlan as RuimtelijkPlanModel;
use WP_Post;

class Ruimtelijkplan extends AbstractRepository
{
    protected $posttype = 'spatial_plan';

    protected static $globalFields = [];

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post): array
    {
        $model = RuimtelijkPlanModel::makeFrom($post);

        $data = [
            'id'                => $model->getID(),
            'date'              => $model->getDateI18n('Y-m-d H:i:s'),
            'portal_url'        => $this->makePortalURL($model->getPostName()),
            'title'             => $model->getTitle(),
            'image'             => $model->getThumbnail(),
            'content'           => $model->getContent(),
            'excerpt'           => $model->getExcerpt(65),
            'slug'              => $model->getPostName(),
            'type'              => $model->getPostType()
        ];

        $data = $this->assignFields($data, $post);

        return $data;
    }

    /**
     * Make the portal url used in the portal.
     *
     * @param string $slug
     *
     * @return string
     */
    public function makePortalURL(string $slug): string
    {
        return sprintf('%s/%s/%s', $this->plugin->settings->getPortalURL(), $this->plugin->settings->getPortalItemSlug(), $slug);
    }

    /**
     * Remove expired posts from the query object.
     *
     * @return array
     */
    public static function addFilterExpirationDateParameters(): array
    {
        return [
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key'     => '_owc_spatial_plans_expiration_date',
                    'value'   => date('Y-m-d H:i:s'),
                    'compare' => '>',
                    'type'    => 'DATE'
                ],
                [
                    'key'     => '_owc_spatial_plans_expiration_date',
                    'compare' => 'NOT EXISTS',
                ],
            ]
        ];
    }

    /**
     * Add parameters to tax_query used for filtering items on selected blog (id) slugs.
     *
     * @param string $blogSlug
     *
     * @return array
     */
    public static function addShowOnParameter(string $blogSlug): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'openpub-show-on',
                    'terms'    => sanitize_text_field($blogSlug),
                    'field'    => 'slug',
                    'operator' => 'IN'
                ]
            ]
        ];
    }
}
