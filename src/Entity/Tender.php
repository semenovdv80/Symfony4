<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tender
 *
 * @ORM\Table(name="tender", indexes={@ORM\Index(name="method_id", columns={"method_id"}), @ORM\Index(name="open_date", columns={"open_date"}), @ORM\Index(name="close_date", columns={"close_date"}), @ORM\Index(name="type_id", columns={"type_id"}), @ORM\Index(name="link", columns={"link"}), @ORM\Index(name="organizer", columns={"organizer"}), @ORM\Index(name="name_ru", columns={"name_ru"})})
 * @ORM\Entity
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $typeId;

    /**
     * @var int
     *
     * @ORM\Column(name="method_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $methodId;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ru", type="string", length=255, nullable=false)
     */
    private $nameRu;

    /**
     * @var string
     *
     * @ORM\Column(name="full_description", type="text", length=65535, nullable=false)
     */
    private $fullDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="customer", type="string", length=255, nullable=false)
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="bin_inn", type="string", length=25, nullable=false)
     */
    private $binInn;

    /**
     * @var string
     *
     * @ORM\Column(name="rnn", type="string", length=25, nullable=false)
     */
    private $rnn;

    /**
     * @var string
     *
     * @ORM\Column(name="organizer", type="string", length=255, nullable=false)
     */
    private $organizer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="amount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     */
    private $location;

    /**
     * @var int|null
     *
     * @ORM\Column(name="kato_id", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $katoId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="open_date", type="datetime", nullable=true)
     */
    private $openDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="close_date", type="datetime", nullable=true)
     */
    private $closeDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="app_place_get", type="string", length=255, nullable=true)
     */
    private $appPlaceGet;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="app_open_date", type="datetime", nullable=true)
     */
    private $appOpenDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="app_place_open", type="string", length=255, nullable=true)
     */
    private $appPlaceOpen;

    /**
     * @var string
     *
     * @ORM\Column(name="agent", type="string", length=255, nullable=false)
     */
    private $agent;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     */
    private $link;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="activity", type="datetime", nullable=true)
     */
    private $activity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gzid", type="string", length=25, nullable=true)
     */
    private $gzid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file_cdocs", type="string", length=255, nullable=true)
     */
    private $fileCdocs;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file_itogs", type="string", length=255, nullable=true)
     */
    private $fileItogs;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     */
    private $published = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


}
