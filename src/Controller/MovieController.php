<?php

namespace App\Controller;

use App\Payload\MoviePayload;
use App\Service\DataConverter;
use App\Service\MovieHandler;
use App\Util\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1")
 */
class MovieController extends AbstractController
{
    private $movieHandler;
    private $dataConverter;
    private $validator;

    public function __construct(MovieHandler $movieHandler, DataConverter $dataConverter, ValidatorInterface $validator)
    {
        $this->movieHandler = $movieHandler;
        $this->dataConverter = $dataConverter;
        $this->validator = $validator;
    }

    /**
     * @Route("/movies", name="save_movie", methods="POST")
     */
    public function postMovies(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);
        $movie = $this->dataConverter->jsonStringToObject(json_encode($payload), MoviePayload::class);
        $movieEntity = $this->movieHandler->prepareMovie($movie);
        $this->movieHandler->saveMovie($movieEntity);
        return new JsonResponse($movieEntity->getName());
    }

    /**
     * @Route("/movies/{id}", name="get_movie_by_id", methods="GET")
     */
    public function getMovieById(int $id){
        return new JsonResponse($this->movieHandler->getMovie(Constants::USER_ID, $id));
    }

    /**
     * @Route("/movies", name="get_movie", methods="GET")
     */
    public function getMovies(): JsonResponse
    {
        return new JsonResponse($this->movieHandler->getAllMovies(Constants::USER_ID));
    }

}
