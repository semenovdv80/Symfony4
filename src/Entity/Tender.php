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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getMethodId(): ?int
    {
        return $this->methodId;
    }

    public function setMethodId(int $methodId): self
    {
        $this->methodId = $methodId;

        return $this;
    }

    public function getNameRu(): ?string
    {
        return $this->nameRu;
    }

    public function setNameRu(string $nameRu): self
    {
        $this->nameRu = $nameRu;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getBinInn(): ?string
    {
        return $this->binInn;
    }

    public function setBinInn(string $binInn): self
    {
        $this->binInn = $binInn;

        return $this;
    }

    public function getRnn(): ?string
    {
        return $this->rnn;
    }

    public function setRnn(string $rnn): self
    {
        $this->rnn = $rnn;

        return $this;
    }

    public function getOrganizer(): ?string
    {
        return $this->organizer;
    }

    public function setOrganizer(string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getKatoId(): ?int
    {
        return $this->katoId;
    }

    public function setKatoId(?int $katoId): self
    {
        $this->katoId = $katoId;

        return $this;
    }

    public function getOpenDate(): ?\DateTimeInterface
    {
        return $this->openDate;
    }

    public function setOpenDate(?\DateTimeInterface $openDate): self
    {
        $this->openDate = $openDate;

        return $this;
    }

    public function getCloseDate(): ?\DateTimeInterface
    {
        return $this->closeDate;
    }

    public function setCloseDate(?\DateTimeInterface $closeDate): self
    {
        $this->closeDate = $closeDate;

        return $this;
    }

    public function getAppPlaceGet(): ?string
    {
        return $this->appPlaceGet;
    }

    public function setAppPlaceGet(?string $appPlaceGet): self
    {
        $this->appPlaceGet = $appPlaceGet;

        return $this;
    }

    public function getAppOpenDate(): ?\DateTimeInterface
    {
        return $this->appOpenDate;
    }

    public function setAppOpenDate(?\DateTimeInterface $appOpenDate): self
    {
        $this->appOpenDate = $appOpenDate;

        return $this;
    }

    public function getAppPlaceOpen(): ?string
    {
        return $this->appPlaceOpen;
    }

    public function setAppPlaceOpen(?string $appPlaceOpen): self
    {
        $this->appPlaceOpen = $appPlaceOpen;

        return $this;
    }

    public function getAgent(): ?string
    {
        return $this->agent;
    }

    public function setAgent(string $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getActivity(): ?\DateTimeInterface
    {
        return $this->activity;
    }

    public function setActivity(?\DateTimeInterface $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getGzid(): ?string
    {
        return $this->gzid;
    }

    public function setGzid(?string $gzid): self
    {
        $this->gzid = $gzid;

        return $this;
    }

    public function getFileCdocs(): ?string
    {
        return $this->fileCdocs;
    }

    public function setFileCdocs(?string $fileCdocs): self
    {
        $this->fileCdocs = $fileCdocs;

        return $this;
    }

    public function getFileItogs(): ?string
    {
        return $this->fileItogs;
    }

    public function setFileItogs(?string $fileItogs): self
    {
        $this->fileItogs = $fileItogs;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
