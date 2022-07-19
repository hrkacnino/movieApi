<?php

namespace App\Response;

use App\Entity\Movie;

class MovieResponse
{
    public function build(Movie $movie)
    {
        $this->name = $movie->getName();
        $this->casts = $movie->getCasts();
        $this->release_date = $movie->getReleaseDate()->format('d-m-Y');
        $this->director = $movie->getDirector();
        $this->ratings = $movie->getRatings();
    }

    public $name;

    public $casts;

    public $release_date;

    public $director;

    public $ratings;
}
