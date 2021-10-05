<?php

namespace App\JwPlayer\API\Models;

use App\JwPlayer\API\API;
use App\JwPlayer\API\Models\Traits\CanProcessResponse;
use App\JwPlayer\API\Models\Traits\HasPages;
use App\JwPlayer\API\Models\Traits\HasSite;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class MediaList
{
    use HasPages;
    use HasSite;
    use CanProcessResponse;

    public const SORT_CREATED = 'created';
    public const SORT_DURATION = 'duration';
    public const SORT_LAST_MODIFIED = 'last_modified';
    public const SORT_TITLE = 'title';
    public const SORT_PUBLISH_START_DATE = 'publish_start_date';
    public const SORT_PUBLISH_END_DATE = 'publish_end_date';
    public const SORT_STATUS = 'status';
    public const SORT_DIRECTION_ASCENDING = 'asc';
    public const SORT_DIRECTION_DESCENDING = 'dsc';

    public function items(): Collection
    {
        return $this->items;
    }

    public function get(
        $page = 1,
        $pageLength = 50,
        $query = '',
        $sortBy = self::SORT_CREATED,
        $direction = self::SORT_DIRECTION_DESCENDING
    ) {
        try {
            $response = $this->getAPI()
                ->client()
                ->get('sites/' . $this->getSiteId() . '/media', [
                    'query' => [
                        'page' => $page,
                        'page_length' => $pageLength,
                        'query' => $query,
                        'sort' => join(':', [$sortBy, $direction])
                    ]
                ]);

            return $this->processCollectionResponse(
                $response,
                'media',
                Media::class
            );
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    public function find($mediaId): Media
    {
        try {
            $response = $this->getAPI()
                ->client()
                ->get('sites/' . $this->getSiteId() . '/media/' . $mediaId);

            return $this->processResponse($response, Media::class);
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    protected function getAPI()
    {
        return resolve(API::class);
    }
}
