<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactNumberRepository")
 */
class ContactNumber
{
    use EntityIdTrait;

    const TYPE_OFFICE = 1;
    const TYPE_MOBILE = 2;
    const TYPE_HOME = 3;
    const TYPE_FAX = 4;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="contactNumbers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->type = self::TYPE_OFFICE;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
