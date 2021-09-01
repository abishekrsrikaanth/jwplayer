<?php

namespace App\JwPlayer;

use App\JwPlayer\API\Models\PlayList;
use App\JwPlayer\API\Models\PlayLists;

class JwPlayer
{
    public function getPlaylists(
        $page = 1,
        $pageLength = 10,
        $query = '',
        $sortBy = PlayLists::SORT_CREATED,
        $direction = PlayLists::SORT_DIRECTION_DESCENDING
    ): PlayLists {
        $playlists = resolve(PlayLists::class);

        return $playlists->get($page, $pageLength, $query, $sortBy, $direction);
    }

    public function findPlaylist(string $playListId): PlayList
    {
        $playlists = resolve(PlayLists::class);

        return $playlists->find($playListId);
    }

    public function findManualPlaylist(string $playlistId): PlayList
    {
        $playlists = resolve(PlayLists::class);

        return $playlists->findManualPlaylist($playlistId);
    }
}
