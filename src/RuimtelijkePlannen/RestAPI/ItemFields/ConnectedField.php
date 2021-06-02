<?php

namespace OWC\RuimtelijkePlannen\RestAPI\ItemFields;

use OWC\RuimtelijkePlannen\Foundation\Plugin;
use OWC\RuimtelijkePlannen\Models\RuimtelijkPlan as RuimtelijkPlanModel;
use OWC\RuimtelijkePlannen\Repositories\Ruimtelijkplan;
use OWC\RuimtelijkePlannen\Support\CreatesFields;
use WP_Post;
use WP_Query;

class ConnectedField extends CreatesFields
{
    /**
     * Instance of the Plugin.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin      = $plugin;
        $this->respository = new Ruimtelijkplan($plugin);
    }

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $model            = RuimtelijkPlanModel::makeFrom($post);
        $showOnTermSlugs  = $this->getShowOnTermSlugs($model);

        return $this->getConnectedItems($showOnTermSlugs, $model->getID());
    }

    /**
     * @param RuimtelijkPlanModel $model
     *
     * @return array
     */
    protected function getShowOnTermSlugs(RuimtelijkPlanModel $model): array
    {
        $terms = $model->getTerms('openpub-show-on');

        if (!is_array($terms)) {
            return [];
        }

        return array_map(function ($term) {
            return $term->slug;
        }, $terms);
    }

    /**
     * Get connected items and exclude current post.
     *
     * @param array $showOnTermSlugs
     * @param integer $postID
     *
     * @return array
     */
    protected function getConnectedItems(array $showOnTermSlugs, int $postID): array
    {
        $items = $this->query($showOnTermSlugs, $postID);

        if (empty($items)) {
            return [];
        }

        return array_map(function (WP_Post $post) {
            $model = RuimtelijkPlanModel::makeFrom($post);

            return [
                'id'                => $model->getID(),
                'date'              => $model->getDateI18n('Y-m-d H:i:s'),
                'portal_url'        => $this->respository->makePortalURL($model->getPostName()),
                'title'             => $model->getTitle(),
                'image'             => $model->getThumbnail(),
                'content'           => $model->getContent(),
                'excerpt'           => $model->getExcerpt(),
                'slug'              => $model->getPostName(),
                'type'              => $model->getPostType()
            ];
        }, $items);
    }

    /**
     * Get connected items based on taxonomy.
     *
     * @param array $showOnTermSlugs
     * @param integer $postID
     *
     * @return array
     */
    protected function query(array $showOnTermSlugs, int $postID): array
    {
        $args = [
            'post_type' => 'spatial_plan',
            'post__not_in' => [$postID],
            'meta_query' => $this->getMetaQuery()
        ];


        if ($this->plugin->settings->useShowOn()) {
            $args['tax_query'] = $this->getTaxQuery($showOnTermSlugs);
        }

        $query = new WP_Query($args);

        return $query->posts;
    }

    protected function getMetaQuery(): array
    {
        return [
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
        ];
    }

    protected function getTaxQuery($showOnTermSlugs): array
    {
        $showOnTermSlugs = $this->filterShowOnTermSlugs($showOnTermSlugs);

        return [
            [
                'taxonomy' => 'openpub-show-on',
                'field'    => 'slug',
                'terms'    => $showOnTermSlugs,
            ]
        ];
    }

    /**
     * Only use the slug of the term that corresponds with the param 'source'.
     * If the param 'source' is not set return all.
     *
     * @param array $showOnTermSlugs
     * 
     * @return array
     */
    protected function filterShowOnTermSlugs(array $showOnTermSlugs): array
    {
        $source = sanitize_text_field($_REQUEST['source'] ?? '');

        if (empty($source) || !is_numeric($source)) {
            return $showOnTermSlugs;
        }

        return array_filter($showOnTermSlugs, function ($term) use ($source) {
            return $term == $source;
        });
    }
}
