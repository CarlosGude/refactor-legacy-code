<?php

namespace App\Infrastructure\Http;

use App\Application\DataTransformer\RequestToUserInputDto;
use App\Application\Dto\Input\UserInputDto;
use App\Application\Exception\DataNotValidException;
use App\Application\Exception\RequestNotValidException;
use App\Application\UseCase\PostUserCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PostUserController extends AbstractController
{
    /**
     * @throws DataNotValidException
     */
    #[Route('api/user', name: 'put_entity_one', methods: ['POST'])]
    public function post(Request $request, PostUserCase $postUserCase): JsonResponse
    {
        $request = $request->toArray();
        $response = null;
        $dto = null;
        $data = [];

        try {
            $dto = (new RequestToUserInputDto($request))->transform();
        } catch (RequestNotValidException $exception) {
            $response = $this->json($exception->getMessage(), 400);
        }

        if (!$response && $dto instanceof UserInputDto) {
            $userDto = $postUserCase->userExist($dto);
            if ($userDto) {
                $response = $this->json($postUserCase->post($dto), 200);
            }

            $data = $postUserCase->post($dto);
            if ($data instanceof DataNotValidException && !$response) {
                $response = $this->json($data->getErrors(), 400);
            }
        }

        return $response ?? $this->json($data, 201);
    }
}
