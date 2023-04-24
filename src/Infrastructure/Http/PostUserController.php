<?php

namespace App\Infrastructure\Http;

use App\Application\DataTransformer\RequestToUserInputDto;
use App\Application\Exception\RequestNotValidException;
use App\Application\UseCase\PostUserCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PostUserController extends AbstractController
{
    #[Route('api/user', name: 'put_entity_one', methods: ['POST'])]
    public function post(Request $request, PostUserCase $postUserCase): JsonResponse
    {
        $request = $request->toArray();

        try {
            $dto = (new RequestToUserInputDto($request))->transform();
        } catch (RequestNotValidException $exception) {
            return $this->json($exception->getMessage(), 400);
        }

        $userDto = $postUserCase->userExist($dto);
        if ($userDto) {
            return $this->json($postUserCase->post($dto));
        }

        return $this->json($postUserCase->post($dto), 201);
    }
}
