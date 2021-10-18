<?php

namespace App\JwPlayer\API\Models\Traits;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

trait CanProcessResponse
{
    protected Collection $items;
    protected array $data;

    protected function processResponse(
        ResponseInterface $response,
        string $class
    ) {
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $contents = json_decode($response->getBody()->getContents(), true);

            return new $class($contents);
        } else {
            $this->processErrorResponse($response);
        }
    }

    protected function processCollectionResponse(
        ResponseInterface $response,
        string $keyOnCollection,
        string $class
    ) {
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $this->items = new Collection();

            $contents = json_decode($response->getBody()->getContents(), true);

            $this->data = $contents;
            $playlists = Arr::get($contents, $keyOnCollection);

            foreach ($playlists as $playlist) {
                $this->items->add(new $class($playlist));
            }

            return $this;
        } else {
            $this->processErrorResponse($response);
        }
    }

    protected function processErrorResponse(ResponseInterface $response)
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        $description = Arr::get($contents, 'description');

        $errorCode = Arr::get($contents, 'code');

        throw new Exception($description, $errorCode);
    }
}
