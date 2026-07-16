<?php

declare(strict_types=1);

namespace App\Controller\Api\Stations;

use App\Cache\NowPlayingCache;
use App\Controller\SingleActionInterface;
use App\Http\Response;
use App\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;

final class IcyMetadataAction implements SingleActionInterface
{
    public function __construct(
        private readonly NowPlayingCache $nowPlayingCache,
    ) {
    }

    public function __invoke(
        ServerRequest $request,
        Response $response,
        array $params
    ): ResponseInterface {
        $np = $this->nowPlayingCache->getForStation(
            $request->getStation()
        );

        if ($np === null || $np->now_playing === null) {
            return $response->withStatus(204);
        }

        $song = $np->now_playing->song;
        $titleParts = [];

        if (!empty($song->artist)) {
            $titleParts[] = $song->artist;
        }
        if (!empty($song->title)) {
            $titleParts[] = $song->title;
        }

        if (empty($titleParts)) {
            return $response->withStatus(204);
        }

        return $response->renderStringAsFile(
            implode(' - ', $titleParts),
            'text/plain'
        );
    }
}
