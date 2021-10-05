<?php

namespace App\JwPlayer\API\Models;

use App\JwPlayer\API\API;
use App\JwPlayer\API\Models\Traits\CanProcessResponse;
use App\JwPlayer\API\Models\Traits\HasPages;
use App\JwPlayer\API\Models\Traits\HasSite;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class PlayLists
{
    use HasPages;
    use HasSite;
    use CanProcessResponse;

    public const SORT_CREATED = 'created';
    public const SORT_LAST_MODIFIED = 'last_modified';
    public const SORT_TITLE = 'title';
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
    ): self {
        try {
            $response = $this->getAPI()
                ->client()
                ->get('sites/' . $this->getSiteId() . '/playlists', [
                    'query' => [
                        'page' => $page,
                        'page_length' => $pageLength,
                        'query' => $query,
                        'sort' => join(':', [$sortBy, $direction]),
                    ],
                ]);

            return $this->processCollectionResponse(
                $response,
                'playlists',
                PlayList::class
            );
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    public function find($playlistId): PlayList
    {
        try {
            $response = $this->getAPI()
                ->client()
                ->get(
                    'sites/' . $this->getSiteId() . '/playlists/' . $playlistId
                );

            return $this->processResponse($response, PlayList::class);
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    public function findManualPlaylist(string $playlistId): PlayList
    {
        try {
            $response = $this->getAPI()
                ->client()
                ->get(
                    'sites/' .
                        $this->getSiteId() .
                        '/playlists/' .
                        $playlistId .
                        '/manual_playlist'
                );

            return $this->processResponse($response, PlayList::class);
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    public function findDynamicPlaylist(string $playlistId): PlayList
    {
        try {
            $response = $this->getAPI()
                ->client()
                ->get(
                    'sites/' .
                        $this->getSiteId() .
                        '/playlists/' .
                        $playlistId .
                        '/dynamic_playlist'
                );

            return $this->processResponse($response, PlayList::class);
        } catch (GuzzleException $e) {
            throw new Exception(
                'Error Processing Request. ' . $e->getMessage()
            );
        }
    }

    public static function delete($playlistId)
    {
    }

    protected function getAPI()
    {
        return resolve(API::class);
    }
}
