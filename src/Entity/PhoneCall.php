<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneCallRepository")
 */
class PhoneCall
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $recordingUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContactAction", inversedBy="phoneCalls")
     */
    private $contactAction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getRecordingUrl(): ?string
    {
        return $this->recordingUrl;
    }

    public function setRecordingUrl(?string $recordingUrl): self
    {
        $this->recordingUrl = $recordingUrl;

        return $this;
    }

    public function getContactAction(): ?ContactAction
    {
        return $this->contactAction;
    }

    public function setContactAction(?ContactAction $contactAction): self
    {
        $this->contactAction = $contactAction;

        return $this;
    }
}
