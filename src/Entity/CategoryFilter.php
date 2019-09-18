<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryFilterRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CategoryFilter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Exclude
     */
    private $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     * @JMS\Accessor(getter="getUuidAsString")
     * @JMS\Groups({"categoryFilter_basic"})
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Groups({"categoryFilter_basic"})
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     * @JMS\Groups({"categoryFilter_basic"})
     */
    private $filters = [];

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function setupUuid()
    {
        $this->setUuid(Uuid::uuid4());
        return $this;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getUuidAsString(): ?string
    {
        return $this->uuid->toString();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }



}