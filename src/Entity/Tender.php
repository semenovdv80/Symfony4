<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tender
 *
 * @ORM\Table(name="tender")
 * @ORM\Entity(repositoryClass="App\Repository\TenderRepository")
 */
class Tender
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ru", type="string", length=255, nullable=false)
     */
    private $nameRu;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lot", mappedBy="tender")
     */
    private $lots;

    public function __construct()
    {
        $this->lots = new ArrayCollection();
    }

    /**
     * @return Collection|Lot[]
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }


}
