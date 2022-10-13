<?php

namespace App\Controller;

use App\Formatter\ServerFormatter;
use App\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{

    public function __construct(private ServerRepository $serverRepository,
                                private ServerFormatter $serverFormatter) {
    }

    public function setServerRepository(ServerRepository $serverRepository): void
    {
        $this->serverRepository = $serverRepository;
    }

    public function getServerRepository(): ServerRepository
    {
        return $this->serverRepository;
    }

    public function setServerFormatter(ServerFormatter $serverFormatter): void
    {
        $this->serverFormatter = $serverFormatter;
    }

    public function getServerFormatter(): ServerFormatter
    {
        return $this->serverFormatter;
    }

    #[Route('/servers', name: 'app_server')]
    public function index(): JsonResponse
    {

        try {
            $servers = $this->getServerRepository()->getAll();
            $serversArray = $this->getServerFormatter()->formatObjects($servers);
            return  $this->json($serversArray);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'status' => 'Failed'],
                Response::HTTP_BAD_REQUEST);
        }
    }
}
