<?php

namespace App\Controller;

use App\Formatter\RamModuleFormatter;
use App\Repository\RamModuleRepository;
use App\Service\RamModuleService;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RamModuleController extends AbstractController
{
    public function __construct(private RamModuleRepository $ramModuleRepository,
                                private RamModuleFormatter $ramModuleFormatter,
                                private RamModuleService $ramModuleService) {
    }

    public function setRamModuleRepository(RamModuleRepository $ramModuleRepository): void
    {
        $this->ramModuleRepository = $ramModuleRepository;
    }

    public function getRamModuleRepository(): RamModuleRepository
    {
        return $this->ramModuleRepository;
    }

    public function setRamModuleService(RamModuleService $ramModuleService): void
    {
        $this->ramModuleService = $ramModuleService;
    }

    public function getRamModuleService(): RamModuleService
    {
        return $this->ramModuleService;
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
    public function add(Request $request): JsonResponse
    {
        try {
            $this->validateAdd($request);
            $ramModule = $this->getRamModuleService()->createAndSave($request);
            $ramModuleArray = $this->getRamModuleFormatter()->formatObject($ramModule);
            return  $this->json($ramModuleArray);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'status' => 'Failed'],
                Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     */
    protected function validateAdd(Request $request) : void
    {

        try {
            v::keySet(
                v::key('size', v::positive(), true),
                v::key('type', v::stringType(), true),
            )->assert(json_decode($request->getContent(), true));
        } catch (NestedValidationException $e) {
            throw new BadRequestHttpException($e->getFullMessage());
        }

    }
}
