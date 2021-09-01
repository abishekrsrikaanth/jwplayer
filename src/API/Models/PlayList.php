<?php

namespace App\JwPlayer\API\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

class PlayList
{
    public function __construct(private array $data)
    {
    }

    public function getId()
    {
        return Arr::get($this->data, 'id');
    }

    public function getCreatedAt()
    {
        return CarbonImmutable::parse(Arr::get($this->data, 'created'));
    }

    public function getLastModified()
    {
        return CarbonImmutable::parse(Arr::get($this->data, 'last_modified'));
    }

    public function getDescription()
    {
        return Arr::get($this->data, 'metadata.description');
    }

    public function getTitle()
    {
        return Arr::get($this->data, 'metadata.title');
    }

    public function getPlaylistType()
    {
        return Arr::get($this->data, 'playlist_type');
    }

    public function getMediaKeys()
    {
        return Arr::get($this->data, 'metadata.media_filter.include.values');
    }
}
