<?php

namespace App\JwPlayer\API\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

class Media
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

    public function getPublishStartDate()
    {
        return CarbonImmutable::parse(
            Arr::get($this->data, 'metadata.publish_start_date')
        );
    }

    public function getPublishEndDate()
    {
        return CarbonImmutable::parse(
            Arr::get($this->data, 'metadata.publish_end_date')
        );
    }

    public function getDescription()
    {
        return Arr::get($this->data, 'metadata.description');
    }

    public function getTitle()
    {
        return Arr::get($this->data, 'metadata.title');
    }

    public function getDuration()
    {
        return Arr::get($this->data, 'metadata.duration');
    }

    public function getPermalink()
    {
        return Arr::get($this->data, 'metadata.permalink');
    }

    public function getCategory()
    {
        return Arr::get($this->data, 'metadata.category');
    }

    public function getTags()
    {
        return Arr::get($this->data, 'metadata.tags');
    }

    public function getMimeType()
    {
        return Arr::get($this->data, 'mime_type');
    }
}
