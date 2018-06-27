<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lot
 *
 * @ORM\Table(name="lot", indexes={@ORM\Index(name="IDX_B81291B9245DE54", columns={"tender_id"})})
 * @ORM\Entity
 */
class Lot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tender", inversedBy="lots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tender;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    public function getTender(): ?Tender
    {
        return $this->tender;
    }

    public function setTender(Tender $tender): self
    {
        $this->tender = $tender;

        return $this;
    }


}
