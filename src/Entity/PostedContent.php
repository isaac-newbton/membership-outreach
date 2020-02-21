<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostedContentRepository")
 */
class PostedContent
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $externalId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $permalink;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $meta = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostedContentHit", mappedBy="postedContent", orphanRemoval=true)
     * @ORM\OrderBy({"datetime" = "DESC"})
     */
    private $postedContentHits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="postedContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization;

    public function __construct(){
        $this->uuid = Uuid::uuid4();
        $this->meta = [];
        $this->postedContentHits = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPermalink(): ?string
    {
        return $this->permalink;
    }

    public function setPermalink(?string $permalink): self
    {
        $this->permalink = $permalink;

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

    /**
     * @return Collection|PostedContentHit[]
     */
    public function getPostedContentHits(): Collection
    {
        return $this->postedContentHits;
    }

    public function addPostedContentHit(PostedContentHit $postedContentHit): self
    {
        if (!$this->postedContentHits->contains($postedContentHit)) {
            $this->postedContentHits[] = $postedContentHit;
            $postedContentHit->setPostedContent($this);
        }

        return $this;
    }

    public function removePostedContentHit(PostedContentHit $postedContentHit): self
    {
        if ($this->postedContentHits->contains($postedContentHit)) {
            $this->postedContentHits->removeElement($postedContentHit);
            // set the owning side to null (unless already changed)
            if ($postedContentHit->getPostedContent() === $this) {
                $postedContentHit->setPostedContent(null);
            }
        }

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}
