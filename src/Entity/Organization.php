<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Survey", mappedBy="organization")
     */
    private $surveys;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $custom_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="organizations")
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPerson;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetAddress1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $directoryUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactFax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactOtherNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $membershipCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostedContent", mappedBy="organization", orphanRemoval=true)
     */
    private $postedContents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="organization", orphanRemoval=true)
     * @ORM\OrderBy({"isPrimary" = "DESC"})
     */
    private $contacts;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->postedContents = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setOrganization($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->contains($survey)) {
            $this->surveys->removeElement($survey);
            // set the owning side to null (unless already changed)
            if ($survey->getOrganization() === $this) {
                $survey->setOrganization(null);
            }
        }

        return $this;
    }

    public function getCustomId(): ?string
    {
        return $this->custom_id;
    }

    public function setCustomId(?string $custom_id): self
    {
        $this->custom_id = $custom_id;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getContactPhoneNumber(): ?string
    {
        return $this->contactPhoneNumber;
    }

    public function setContactPhoneNumber(?string $contactPhoneNumber): self
    {
        $this->contactPhoneNumber = $contactPhoneNumber;

        return $this;
    }

    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    public function setContactPerson(?string $contactPerson): self
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getStreetAddress1(): ?string
    {
        return $this->streetAddress1;
    }

    public function setStreetAddress1(?string $streetAddress1): self
    {
        $this->streetAddress1 = $streetAddress1;

        return $this;
    }

    public function getStreetAddress2(): ?string
    {
        return $this->streetAddress2;
    }

    public function setStreetAddress2(?string $streetAddress2): self
    {
        $this->streetAddress2 = $streetAddress2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getDirectoryUrl(): ?string
    {
        return $this->directoryUrl;
    }

    public function setDirectoryUrl(?string $directoryUrl): self
    {
        $this->directoryUrl = $directoryUrl;

        return $this;
    }

    public function getContactFax(): ?string
    {
        return $this->contactFax;
    }

    public function setContactFax(?string $contactFax): self
    {
        $this->contactFax = $contactFax;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getContactOtherNumber(): ?string
    {
        return $this->contactOtherNumber;
    }

    public function setContactOtherNumber(?string $contactOtherNumber): self
    {
        $this->contactOtherNumber = $contactOtherNumber;

        return $this;
    }

    public function getMembershipCategory(): ?string
    {
        return $this->membershipCategory;
    }

    public function setMembershipCategory(?string $membershipCategory): self
    {
        $this->membershipCategory = $membershipCategory;

        return $this;
    }

    /**
     * @return Collection|PostedContent[]
     */
    public function getPostedContents(): Collection
    {
        return $this->postedContents;
    }

    public function addPostedContent(PostedContent $postedContent): self
    {
        if (!$this->postedContents->contains($postedContent)) {
            $this->postedContents[] = $postedContent;
            $postedContent->setOrganization($this);
        }

        return $this;
    }

    public function removePostedContent(PostedContent $postedContent): self
    {
        if ($this->postedContents->contains($postedContent)) {
            $this->postedContents->removeElement($postedContent);
            // set the owning side to null (unless already changed)
            if ($postedContent->getOrganization() === $this) {
                $postedContent->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setOrganization($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getOrganization() === $this) {
                $contact->setOrganization(null);
            }
        }

        return $this;
    }
}
