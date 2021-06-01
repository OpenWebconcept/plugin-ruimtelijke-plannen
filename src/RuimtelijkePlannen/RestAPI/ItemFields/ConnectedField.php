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
        $model          = RuimtelijkPlanModel::makeFrom($post);
        $showOnTermIDs  = $this->getShowOnTermIDs($model);

        return $this->getConnectedItems($showOnTermIDs, $model->getID());
    }

    /**
     * @param RuimtelijkPlanModel $model
     *
     * @return array
     */
    protected function getShowOnTermIDs(RuimtelijkPlanModel $model): array
    {
        $terms = $model->getTerms('openpub-show-on');

        if (!is_array($terms)) {
            return [];
        }

        return array_map(function ($term) {
            return $term->term_id;
        }, $terms);
    }

    /**
     * Get connected items and exclude current post.
     *
     * @param array $showOnTermIDs
     * @param integer $postID
     *
     * @return array
     */
    protected function getConnectedItems(array $showOnTermIDs, int $postID): array
    {
        $items = $this->query($showOnTermIDs, $postID);

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
     * @param array $showOnTermIDs
     * @param integer $postID
     *
     * @return array
     */
    protected function query(array $showOnTermIDs, int $postID): array
    {
        $args = [
            'post_type' => 'spatial_plan',
            'tax_query' => [
                [
                    'taxonomy' => 'openpub-show-on',
                    'field'    => 'term_id',
                    'terms'    => $showOnTermIDs,
                ]
            ],
            'post__not_in' => [$postID]
        ];

        $query = new WP_Query($args);

        return $query->posts;
    }
}
