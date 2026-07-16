<?php

declare(strict_types=1);

namespace App\Controller\Api\Stations\LunaRadioConfig;

use App\Container\EntityManagerAwareTrait;
use App\Controller\SingleActionInterface;
use App\Entity\Api\Status;
use App\Http\Response;
use App\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;

final class PutAction implements SingleActionInterface
{
    use EntityManagerAwareTrait;

    public function __invoke(
        ServerRequest $request,
        Response $response,
        array $params
    ): ResponseInterface {
        $body = (array)$request->getParsedBody();
        $station = $this->em->refetch($request->getStation());

        $branding = $station->branding_config;
        $branding->lunaradio_config = $body;
        $station->branding_config = $branding;

        $this->em->persist($station);
        $this->em->flush();

        return $response->withJson(Status::updated());
    }
}
