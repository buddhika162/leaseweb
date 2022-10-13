<?php

namespace App\Controller;

use App\Formatter\RamModuleFormatter;
use App\Repository\RamModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RamModuleController extends AbstractController
{
    public function __construct(private RamModuleRepository $ramModuleRepository,
                                private RamModuleFormatter $ramModuleFormatter) {
    }

    public function setRamModulerRepository(RamModuleRepository $ramModuleRepository): void
    {
        $this->ramModuleRepository = $ramModuleRepository;
    }

    public function getRamModuleRepository(): RamModuleRepository
    {
        return $this->ramModuleRepository;
    }

    public function setRamModuleFormatter(RamModuleFormatter $ramModuleFormatter): void
    {
        $this->ramModuleFormatter = $ramModuleFormatter;
    }

    public function getRamModuleFormatter(): RamModuleFormatter
    {
        return $this->ramModuleFormatter;
    }
    #[Route('/ramModules', name: 'app_ram_module', methods:['GET'] )]
    public function index(): JsonResponse
    {
        try {
            $ramModules = $this->getRamModuleRepository()->getAll();
            $ramModulesArray = $this->getRamModuleFormatter()->formatObjects($ramModules);
            return  $this->json($ramModulesArray);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'status' => 'Failed'],
                Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/ramModules', name: 'app_ram_module', methods:['Post'] )]
    public function add(): JsonResponse
    {
        try {
            $ramModules = $this->getRamModuleRepository()->getAll();
            $ramModulesArray = $this->getRamModuleFormatter()->formatObjects($ramModules);
            return  $this->json($ramModulesArray);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'status' => 'Failed'],
                Response::HTTP_BAD_REQUEST);
        }
    }
}
