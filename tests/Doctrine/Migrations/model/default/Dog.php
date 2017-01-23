<?php

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Dog {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @var string
     */
    private $name;
}
