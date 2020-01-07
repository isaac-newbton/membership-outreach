<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $toEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fromEmail;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $ccEmail;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $bccEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContactAction", inversedBy="emails")
     */
    private $contactAction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    public function setToEmail(?string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(?string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function getCcEmail(): ?string
    {
        return $this->ccEmail;
    }

    public function setCcEmail(?string $ccEmail): self
    {
        $this->ccEmail = $ccEmail;

        return $this;
    }

    public function getBccEmail(): ?string
    {
        return $this->bccEmail;
    }

    public function setBccEmail(?string $bccEmail): self
    {
        $this->bccEmail = $bccEmail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

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
