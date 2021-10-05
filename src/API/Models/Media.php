<?php

namespace App\JwPlayer\API\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

class Media
{
    public function __construct(private array $data)
    {
    }

    public function getId(): string
    {
        return Arr::get($this->data, 'id');
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return CarbonImmutable::parse(Arr::get($this->data, 'created'));
    }

    public function getLastModified(): CarbonImmutable
    {
        return CarbonImmutable::parse(Arr::get($this->data, 'last_modified'));
    }

    public function getPublishStartDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            Arr::get($this->data, 'metadata.publish_start_date')
        );
    }

    public function getPublishEndDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            Arr::get($this->data, 'metadata.publish_end_date')
        );
    }

    public function getDescription(): string
    {
        return Arr::get($this->data, 'metadata.description');
    }

    public function getTitle(): string
    {
        return Arr::get($this->data, 'metadata.title');
    }

    public function getDuration(): int
    {
        return Arr::get($this->data, 'metadata.duration');
    }

    public function getPermalink(): string
    {
        return Arr::get($this->data, 'metadata.permalink');
    }

    public function getCategory(): string
    {
        return Arr::get($this->data, 'metadata.category');
    }

    public function getTags(): array
    {
        return Arr::get($this->data, 'metadata.tags');
    }

    public function getMimeType(): string
    {
        return Arr::get($this->data, 'mime_type');
    }
}
