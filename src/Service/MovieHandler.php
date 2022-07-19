<?php

namespace App\Service;

use App\Exception\BadParameterException;
use App\Payload\MoviePayload;
use App\Repository\MovieRepository;
use \App\Entity\Movie as MovieEntity;
use App\Response\MovieResponse;
use App\Util\Constants;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MovieHandler
{
    private $movieRepository;
    private $validator;
    private $logger;

    public function __construct(MovieRepository $movieRepository, ValidatorInterface $validator, LoggerInterface $logger){
        $this->movieRepository = $movieRepository;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @throws \Exception
     */
    public function prepareMovie(MoviePayload $movie): MovieEntity
    {
        $errors = $this->validator->validate($movie);
        if($errors->count() == 0) {
            $movieEntity = new MovieEntity();
            $movieEntity->setUserId(Constants::USER_ID);
            $movieEntity->setName($movie->name);
            $movieEntity->setDirector($movie->director);
            $movieEntity->setCasts($movie->casts);
            $movieEntity->setRatings($movie->ratings);
            try {
                $movieEntity->setReleaseDate(new \DateTime($movie->release_date));
            }catch (\Exception $exception){
                $this->logger->error("Release date invalid!");
                throw $exception;
            }
            return $movieEntity;
        }else{
            throw new BadParameterException("Validation error! ".$errors[0]->getMessage());
        }
    }

    public function saveMovie(MovieEntity $movie){
        $this->movieRepository->save($movie);
    }

    public function getMovie(int $userId, int $movieId): MovieResponse
    {
        $movie = $this->movieRepository->findOneBy(["userId" => $userId, "id"=> $movieId]);
        $movieResponse = new MovieResponse();
        $movieResponse->build($movie);
        return $movieResponse;
    }

    public function getAllMovies($userId): array
    {
        $movies = $this->movieRepository->findBy(["userId" => $userId]);
        $result = [];
        foreach ($movies as $movie){
            $movieResponse = new MovieResponse();
            $movieResponse->build($movie);
            $result[] = $movieResponse;
        }
        return $result;
    }

}
