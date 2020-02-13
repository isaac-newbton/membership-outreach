<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApiKeyRepository")
 */
class ApiKey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contents;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_datetime;

    public function __construct()
    {
        $this->contents = bin2hex(random_bytes(24));
        $this->enabled = true;
        $this->created_datetime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCreatedDatetime(): ?\DateTimeInterface
    {
        return $this->created_datetime;
    }

    public function setCreatedDatetime(\DateTimeInterface $created_datetime): self
    {
        $this->created_datetime = $created_datetime;

        return $this;
    }
}
