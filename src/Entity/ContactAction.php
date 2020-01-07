<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactActionRepository")
 */
class ContactAction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Survey")
     */
    private $survey;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PhoneCall", mappedBy="contactAction")
     */
    private $phoneCalls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Email", mappedBy="contactAction")
     */
    private $emails;

    public function __construct()
    {
        $this->phoneCalls = new ArrayCollection();
        $this->emails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|PhoneCall[]
     */
    public function getPhoneCalls(): Collection
    {
        return $this->phoneCalls;
    }

    public function addPhoneCall(PhoneCall $phoneCall): self
    {
        if (!$this->phoneCalls->contains($phoneCall)) {
            $this->phoneCalls[] = $phoneCall;
            $phoneCall->setContactAction($this);
        }

        return $this;
    }

    public function removePhoneCall(PhoneCall $phoneCall): self
    {
        if ($this->phoneCalls->contains($phoneCall)) {
            $this->phoneCalls->removeElement($phoneCall);
            // set the owning side to null (unless already changed)
            if ($phoneCall->getContactAction() === $this) {
                $phoneCall->setContactAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Email[]
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function addEmail(Email $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails[] = $email;
            $email->setContactAction($this);
        }

        return $this;
    }

    public function removeEmail(Email $email): self
    {
        if ($this->emails->contains($email)) {
            $this->emails->removeElement($email);
            // set the owning side to null (unless already changed)
            if ($email->getContactAction() === $this) {
                $email->setContactAction(null);
            }
        }

        return $this;
    }
}
