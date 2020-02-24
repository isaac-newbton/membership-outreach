<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    use EntityIdTrait;

    const TYPE_OWNER = 1;
    const TYPE_BUSINESS = 2;
    const TYPE_SALES = 3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactNumber", mappedBy="contact", orphanRemoval=true)
     */
    private $contactNumbers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization;

    public function __construct()
    {
        $this->contactNumbers = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
        $this->type = self::TYPE_OWNER;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|ContactNumber[]
     */
    public function getContactNumbers(): Collection
    {
        return $this->contactNumbers;
    }

    public function addContactNumber(ContactNumber $contactNumber): self
    {
        if (!$this->contactNumbers->contains($contactNumber)) {
            $this->contactNumbers[] = $contactNumber;
            $contactNumber->setContact($this);
        }

        return $this;
    }

    public function removeContactNumber(ContactNumber $contactNumber): self
    {
        if ($this->contactNumbers->contains($contactNumber)) {
            $this->contactNumbers->removeElement($contactNumber);
            // set the owning side to null (unless already changed)
            if ($contactNumber->getContact() === $this) {
                $contactNumber->setContact(null);
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
