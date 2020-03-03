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

    const TYPE_UNKNOWN = 0;
    const TYPE_NEW_LEADS = 1;
    const TYPE_OWNER_MANAGER = 2;
    const TYPE_MEMBERSHIP_BENEFITS = 3;
    const TYPE_SAFETY_MANAGER = 4;
    const TYPE_ACCOUNT_PAYABLE = 5;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    public function __construct()
    {
        $this->contactNumbers = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
        $this->type = self::TYPE_UNKNOWN;
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

    public function getTypeString(): ?string{
        switch($this->type){
            case self::TYPE_ACCOUNT_PAYABLE:
                return 'Account payable';
            break;
            case self::TYPE_MEMBERSHIP_BENEFITS:
                return 'Membership benefits';
            break;
            case self::TYPE_NEW_LEADS:
                return 'New leads';
            break;
            case self::TYPE_OWNER_MANAGER:
                return 'Owner/manager';
            break;
            case self::TYPE_SAFETY_MANAGER:
                return 'Safety manager';
            break;
            case self::TYPE_UNKNOWN:
            default:
                return 'Unknown';
            break;
        }
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

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
