<?php

namespace App\Payload;

use Symfony\Component\Validator\Constraints as Assert;

class MoviePayload
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="array")
     */
    public $casts;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    public $release_date;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    public $director;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="array")
     */
    public $ratings;
}
