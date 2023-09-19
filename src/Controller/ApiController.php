<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/getValue', name: 'app_api_get', methods: "GET")]
    public function getValue(Request $request): JsonResponse
    {
        $request->get('value');

        return  $this->json($request);
    }

    #[Route('/postValue', name: 'app_api_post', methods: "POST")]
    public function createValue(Request $request): JsonResponse
    {
        $request = json_decode($request->getContent(), true);

        $responseData = ['message' => 'Utworzono nową wartość', 'data'=> $request];
        return  $this->json($responseData, 201);
    }

    #[Route('/updateValue/{id}', name: 'app_api_update', methods: "PUT")]
    public function updateValue(Request $request, $id): JsonResponse
    {
        $request = json_decode($request->getContent(), true);

        $responseData = ['message' => 'Zaktualizowano wartość o id ' . $id, 'data' => $request];
        return $this->json($responseData);
    }

    #[Route('/deleteValue/{id}', name: 'app_api_delete', methods: "DELETE")]
    public function deleteValue($id): JsonResponse
    {
        $responseData = ['message' => 'Usunięto wartość o id ' . $id];
        return $this->json($responseData);
    }
}
