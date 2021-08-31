<?php

namespace App\JwPlayer;

use App\JwPlayer\API\Models\PlayLists;

class JwPlayer
{
    public function getPlaylists($page = 1, $pageLength = 10, $query = '', $sortBy = PlayLists::SORT_CREATED, $direction = PlayLists::SORT_DIRECTION_DESCENDING)
    {
        $playlists = resolve(PlayLists::class);

        return $playlists->get($page, $pageLength, $query, $sortBy, $direction);
    }
}
