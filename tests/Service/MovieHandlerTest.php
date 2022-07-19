<?php

namespace App\Tests\Service;

use App\Payload\MoviePayload;
use App\Service\MovieHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MovieHandlerTest extends KernelTestCase
{
    public function testPrepareMovie(){

        self::bootKernel();
        $container = static::getContainer();
        $movieHandler = $container->get(MovieHandler::class);
        $moviePayload = new MoviePayload();
        $moviePayload->name = "TestName";
        $moviePayload->ratings = ["imdb" =>  7.8, "rotten_tomatto" => 8.2];
        $moviePayload->casts = ["DiCaprio", "Kate Winslet", "Less"];
        $moviePayload->release_date = "18-01-1998";
        $moviePayload->director = "Test Dir";
        $movieObject = $movieHandler->prepareMovie($moviePayload);

        $this->assertEquals('TestName', $movieObject->getName());
        $this->assertEquals('Test Dir', $movieObject->getDirector());
    }
}
