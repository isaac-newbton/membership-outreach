<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostedContentHitRepository")
 */
class PostedContentHit
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostedContent", inversedBy="postedContentHits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postedContent;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $meta = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    public function __construct(){
        $this->uuid = Uuid::uuid4();
        $this->datetime = new \DateTime();
        $this->meta = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPostedContent(): ?PostedContent
    {
        return $this->postedContent;
    }

    public function setPostedContent(?PostedContent $postedContent): self
    {
        $this->postedContent = $postedContent;

        return $this;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public function setMeta(?array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
}
