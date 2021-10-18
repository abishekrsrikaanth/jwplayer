<?php

namespace App\JwPlayer\API\Models;

use App\JwPlayer\API\API;
use App\JwPlayer\API\Models\Traits\CanProcessResponse;
use App\JwPlayer\API\Models\Traits\HasSite;
use Carbon\CarbonImmutable;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;

class Media
{
    use CanProcessResponse;
    use HasSite;

    public function __construct(protected array $data)
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

    public function getDescription(): string
    {
        return Arr::get($this->data, 'metadata.description') ?? '';
    }

    public function getTitle(): string
    {
        return Arr::get($this->data, 'metadata.title');
    }

    public function getDuration(): int
    {
        return Arr::get($this->data, 'duration');
    }

    public function getPermalink(): string
    {
        return Arr::get($this->data, 'metadata.permalink') ?? '';
    }

    public function getCategory(): string
    {
        return Arr::get($this->data, 'metadata.category') ?? '';
    }

    public function getTags(): array
    {
        return Arr::get($this->data, 'metadata.tags', []) ?? [];
    }

    public function getMimeType(): string
    {
        return Arr::get($this->data, 'mime_type');
    }

    public function update(array $metadata)
    {
        try {
            $response = $this->getAPI()
                ->client()
                ->patch(
                    'sites/' . $this->getSiteId() . '/media/' . $this->getId(),
                    [
                        'json' => [
                            'metadata' => $metadata
                        ]
                    ]
                );

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
