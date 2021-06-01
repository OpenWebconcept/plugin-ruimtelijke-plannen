<?php

namespace OWC\RuimtelijkePlannen\RestAPI\Controllers;

use OWC\RuimtelijkePlannen\Repositories\Ruimtelijkplan;
use WP_Error;
use WP_REST_Request;

class RuimtelijkePlannenController extends BaseController
{
    public function getItems(WP_REST_Request $request)
    {
        $items = (new Ruimtelijkplan($this->plugin))
            ->query($this->getPaginatorParams($request))
            ->query(Ruimtelijkplan::addFilterExpirationDateParameters());

        if ($this->showOnParamIsValid($request) && $this->plugin->settings->useShowOn()) {
            $items->query(Ruimtelijkplan::addShowOnParameter($request->get_param('source')));
        }

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual post item.
     *
     * @param WP_REST_Request $request $request
     *
     * @return array|WP_Error
     * @throws \OWC\RuimtelijkePlannen\Exceptions\PropertyNotExistsException
     * @throws \ReflectionException
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $item = (new Ruimtelijkplan($this->plugin))
            ->query(Ruimtelijkplan::addFilterExpirationDateParameters())
            ->find($id);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf("Item with ID '%d' not found (anymore)", $id), [
                'status' => 404,
            ]);
        }

        return $item;
    }

    /**
     * Get an individual post item by slug.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getItemBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $item = (new Ruimtelijkplan($this->plugin))
            ->query(Ruimtelijkplan::addFilterExpirationDateParameters())
            ->findBySlug($slug);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf("Item with slug '%s' not found", $slug), [
                'status' => 404,
            ]);
        }

        return $item;
    }

    /**
     * Validate if show on param is valid.
     * Param should be a numeric value.
     *
     * @param WP_REST_Request $request
     * @return boolean
     */
    protected function showOnParamIsValid(WP_REST_Request $request): bool
    {
        if (empty($request->get_param('source'))) {
            return false;
        }

        if (!is_numeric($request->get_param('source'))) {
            return false;
        }

        return true;
    }
}
