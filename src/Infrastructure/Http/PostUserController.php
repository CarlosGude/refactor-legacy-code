<?php

namespace App\Infrastructure\Http;

use App\Application\DataTransformer\RequestToUserInputDto;
use App\Application\UseCase\PostUserCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PostUserController extends AbstractController
{
    #[Route('api/articles', name: 'put_entity_one', methods: ['POST'])]
    public function post(Request $request, PostUserCase $postUserCase): JsonResponse
    {
        $request = $request->toArray();
        $dto = new RequestToUserInputDto($request);

        return $this->json($postUserCase->post($dto->transform()));
    }
}
