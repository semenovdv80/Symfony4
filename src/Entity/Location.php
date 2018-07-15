<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="loc_type", nullable=true, type="smallint")
     */
    private $locType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name)
    {
        return $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocType()
    {
        return $this->locType;
    }

    /**
     * @param $locType
     * @return mixed
     */
    public function setLocType($locType)
    {
        return $this->locType = $locType;
    }
}
