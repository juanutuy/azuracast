<?php

declare(strict_types=1);

namespace App\Controller\Frontend\PublicPages;

use App\Controller\SingleActionInterface;
use App\Entity\Repository\CustomFieldRepository;
use App\Http\Response;
use App\Http\ServerRequest;
use App\VueComponent\NowPlayingComponent;
use Psr\Http\Message\ResponseInterface;

final class LunaPlayerAction implements SingleActionInterface
{
    public function __construct(
        private readonly CustomFieldRepository $customFieldRepo,
        private readonly NowPlayingComponent $nowPlayingComponent
    ) {
    }

    public function __invoke(
        ServerRequest $request,
        Response $response,
        array $params
    ): ResponseInterface {
        $response = $response
            ->withHeader('X-Frame-Options', '*')
            ->withHeader('X-Robots-Tag', 'index, nofollow');

        $station = $request->getStation();
        $router = $request->getRouter();
        $playerProps = $this->nowPlayingComponent->getProps($request);

        $embed = $request->getQueryParam('embed');

        if (null !== $embed) {
            return $request->getView()->renderVuePage(
                response: $response,
                component: 'Public/LunaradioWidget',
                id: 'luna-widget',
                layout: 'minimal',
                title: $station->name,
                layoutParams: [
                    'page_class' => 'page-station-public-player-embed station-' . $station->short_name . ' embed',
                    'hide_footer' => true,
                ],
                props: $playerProps,
            );
        }

        $props = [
            'stationName' => $station->name,
            'enableRequests' => $station->enable_requests,
            'downloadPlaylistUri' => $router->named(
                routeName: 'public:playlist',
                routeParams: ['station_id' => $station->short_name, 'format' => 'pls']
            ),
            'requests' => [
                'requestListUri' => $router->named(
                    routeName: 'api:requests:list',
                    routeParams: ['station_id' => $station->id]
                ),
                'showAlbumArt' => $playerProps['showAlbumArt'],
                'customFields' => $this->customFieldRepo->fetchArray(),
            ],
            'player' => $playerProps,
        ];

        return $request->getView()->renderToResponse(
            $response,
            'frontend/public/lunaradio',
            [
                'station' => $station,
                'props' => $props,
                'nowPlayingArtUri' => $router->named(
                    routeName: 'api:nowplaying:art',
                    routeParams: ['station_id' => $station->short_name, 'timestamp' => time()],
                    absolute: true
                ),
            ]
        );
    }
}
