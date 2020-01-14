<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyRepository")
 */
class Survey
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SurveyResponse", mappedBy="survey", orphanRemoval=true)
     */
    private $surveyResponses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SurveyTemplate", inversedBy="surveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $surveyTemplate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="surveys")
     */
    private $organization;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dueDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactAction", mappedBy="survey")
     */
    private $contactActions;

    public function __construct()
    {
        $this->surveyResponses = new ArrayCollection();
        $this->contactActions = new ArrayCollection();
        $this->status = self::STATUS_OPEN;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|SurveyResponse[]
     */
    public function getSurveyResponses(): Collection
    {
        return $this->surveyResponses;
    }

    public function addSurveyResponse(SurveyResponse $surveyResponse): self
    {
        if (!$this->surveyResponses->contains($surveyResponse)) {
            $this->surveyResponses[] = $surveyResponse;
            $surveyResponse->setSurvey($this);
        }

        return $this;
    }

    public function removeSurveyResponse(SurveyResponse $surveyResponse): self
    {
        if ($this->surveyResponses->contains($surveyResponse)) {
            $this->surveyResponses->removeElement($surveyResponse);
            // set the owning side to null (unless already changed)
            if ($surveyResponse->getSurvey() === $this) {
                $surveyResponse->setSurvey(null);
            }
        }

        return $this;
    }

    public function getSurveyTemplate(): ?SurveyTemplate
    {
        return $this->surveyTemplate;
    }

    public function setSurveyTemplate(?SurveyTemplate $surveyTemplate): self
    {
        $this->surveyTemplate = $surveyTemplate;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return Collection|ContactAction[]
     */
    public function getContactActions(): Collection
    {
        return $this->contactActions;
    }

    public function addContactAction(ContactAction $contactAction): self
    {
        if (!$this->contactActions->contains($contactAction)) {
            $this->contactActions[] = $contactAction;
            $contactAction->setSurvey($this);
        }

        return $this;
    }

    public function removeContactAction(ContactAction $contactAction): self
    {
        if ($this->contactActions->contains($contactAction)) {
            $this->contactActions->removeElement($contactAction);
            // set the owning side to null (unless already changed)
            if ($contactAction->getSurvey() === $this) {
                $contactAction->setSurvey(null);
            }
        }

        return $this;
    }
}
