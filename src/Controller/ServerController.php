<?php

namespace App\Controller;

use App\Formatter\ServerFormatter;
use App\Repository\RamModuleRepository;
use App\Repository\ServerRepository;
use App\Service\ServerService;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{

    public function __construct(private ServerRepository $serverRepository,
                                private ServerFormatter $serverFormatter,
                                private RamModuleRepository $ramModuleRepository,
                                private ServerService $serverService) {
    }

    public function setRamModuleRepository(RamModuleRepository $ramModuleRepository): void
    {
        $this->ramModuleRepository = $ramModuleRepository;
    }

    public function getRamModuleRepository(): RamModuleRepository
    {
        return $this->ramModuleRepository;
    }

    public function setServerService(ServerService $serverService): void
    {
        $this->serverService = $serverService;
    }

    public function getServerService(): ServerService
    {
        return $this->serverService;
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

    #[Route('/servers', name: 'app_server', methods:['GET'])]
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

    #[Route('/servers', name: 'app_server_add', methods:['Post'] )]
    public function add(Request $request): JsonResponse
    {
        try {;
            $this->validateAdd($request);
            $server = $this->getServerService()->createAndSave($request);
            $serverArray = $this->getServerFormatter()->formatObject($server);
            return new JsonResponse($serverArray,
                Response::HTTP_CREATED);
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
        $existingAssetIds = $this->getServerRepository()->getAllAssetIds();
        $assetIdUniqueValidator = v::callback(
            function ($value) use ($existingAssetIds) {
                if (in_array($value, $existingAssetIds)) {
                    return false;
                }
                return true;
            })->setName('Server with same asset id already exist');

        $existingRamModuleIds = $this->getRamModuleRepository()->getAllRamModuleIds();

        $ramModulesValidator = v::callback(
            function ($value) use ($existingRamModuleIds) {
                $nonExistingRamModuleIds = array_diff($value, $existingRamModuleIds);
                if ($nonExistingRamModuleIds) {
                    return false;
                }
                return true;
            })->setName('Please select available ram modules or add them first');

        try {
            v::keySet(
                v::key('assetId', v::allOf(v::intVal(), $assetIdUniqueValidator), true),
                v::key('name', v::stringType(), true),
                v::key('brand', v::stringType(), true),
                v::key('price', v::positive(), true),
                v::key('ramModules', v::allOf(v::arrayType(), $ramModulesValidator), true),
            )->assert(json_decode($request->getContent(), true));
        } catch (NestedValidationException $e) {
            throw new BadRequestHttpException($e->getFullMessage());
        }

    }


    #[Route('/servers', name: 'app_server_delete', methods:['DELETE'] )]
    public function delete(Request $request): JsonResponse
    {
        try {;
            $this->validateDelete($request);
            $value = $this->getServerService()->deleteMultipleByAssetId($request);
            return new JsonResponse(['message' => "Successfully Deleted", 'delete count' => $value],
                Response::HTTP_OK);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'status' => 'Failed'],
                Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     */
    protected function validateDelete(Request $request) : void
    {

        try {
            v::keySet(
                v::key('assetIds', v::allOf(v::arrayType(), v::each(v::positive())), true),
            )->assert(json_decode($request->getContent(), true));
        } catch (NestedValidationException $e) {
            throw new BadRequestHttpException($e->getFullMessage());
        }

    }
}
