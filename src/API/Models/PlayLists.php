<?php

namespace App\JwPlayer\API\Models;

use App\JwPlayer\API\API;
use App\JwPlayer\API\Models\Traits\HasPages;
use App\JwPlayer\API\Models\Traits\HasSite;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class PlayLists
{
    use HasPages;
    use HasSite;

    protected Collection $items;

    public const SORT_CREATED = 'created';
    public const SORT_LAST_MODIFIED = 'last_modified';
    public const SORT_TITLE = 'title';
    public const SORT_DIRECTION_ASCENDING = 'asc';
    public const SORT_DIRECTION_DESCENDING = 'dsc';

    public function items(): Collection
    {
        return $this->items;
    }

    public function get($page = 1, $pageLength = 10, $query = '', $sortBy = self::SORT_CREATED, $direction = self::SORT_DIRECTION_DESCENDING): self
    {
        try {
            $response = $this->getAPI()->client()->get('sites/'.$this->getSiteId().'/playlists', [
                'query' => [
                    'page'        => $page,
                    'page_length' => $pageLength,
                    'query'       => $query,
                    'sort'        => join(':', [$sortBy, $direction]),
                ],
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $this->items = new Collection();

                $contents = json_decode($response->getBody()->getContents(), true);

                $playlists = Arr::get($contents, 'playlists');

                foreach ($playlists as $playlist) {
                    $this->items->add(new PlayList($playlist));
                }

                return $this;
            } else {
                $contents = json_decode($response->getBody()->getContents(), true);

                $description = Arr::get($contents, 'description');

                $errorCode = Arr::get($contents, 'code');

                throw new Exception($description, $errorCode);
            }
        } catch (GuzzleException $e) {
            throw new Exception('Error Processing Request. '.$e->getMessage());
        }
    }

    public function find($playlistId)
    {
        try {
            $response = $this->getAPI()->client()->get('sites/'.$this->getSiteId().'/playlists/'.$playlistId);

            if ($response->getStatusCode() == Response::HTTP_OK) {

                $contents = json_decode($response->getBody()->getContents());

                return new PlayList($contents);
            } else {
                $contents = json_decode($response->getBody()->getContents(), true);

                $description = Arr::get($contents, 'description');

                $errorCode = Arr::get($contents, 'code');

                throw new Exception($description, $errorCode);
            }
        } catch (GuzzleException $e) {
            throw new Exception('Error Processing Request. '.$e->getMessage());
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
