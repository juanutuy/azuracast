<?php

declare(strict_types=1);

namespace App\Controller\Api\Stations\LunaRadioConfig;

use App\Container\EntityManagerAwareTrait;
use App\Controller\SingleActionInterface;
use App\Http\Response;
use App\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;

final class GetAction implements SingleActionInterface
{
    use EntityManagerAwareTrait;

    public function __invoke(
        ServerRequest $request,
        Response $response,
        array $params
    ): ResponseInterface {
        $station = $this->em->refetch($request->getStation());
        $branding = $station->branding_config;

        return $response->withJson(
            (array)($branding->lunaradio_config ?? [])
        );
    }
}
