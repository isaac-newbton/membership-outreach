<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $options;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SurveyTemplate", mappedBy="questions")
     */
    private $surveyTemplates;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SurveyResponse", mappedBy="question", orphanRemoval=true)
     */
    private $surveyResponses;

    public function __construct()
    {
        $this->surveyTemplates = new ArrayCollection();
        $this->surveyResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

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

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection|SurveyTemplate[]
     */
    public function getSurveyTemplates(): Collection
    {
        return $this->surveyTemplates;
    }

    public function addSurveyTemplate(SurveyTemplate $surveyTemplate): self
    {
        if (!$this->surveyTemplates->contains($surveyTemplate)) {
            $this->surveyTemplates[] = $surveyTemplate;
            $surveyTemplate->addQuestion($this);
        }

        return $this;
    }

    public function removeSurveyTemplate(SurveyTemplate $surveyTemplate): self
    {
        if ($this->surveyTemplates->contains($surveyTemplate)) {
            $this->surveyTemplates->removeElement($surveyTemplate);
            $surveyTemplate->removeQuestion($this);
        }

        return $this;
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
            $surveyResponse->setQuestion($this);
        }

        return $this;
    }

    public function removeSurveyResponse(SurveyResponse $surveyResponse): self
    {
        if ($this->surveyResponses->contains($surveyResponse)) {
            $this->surveyResponses->removeElement($surveyResponse);
            // set the owning side to null (unless already changed)
            if ($surveyResponse->getQuestion() === $this) {
                $surveyResponse->setQuestion(null);
            }
        }

        return $this;
    }
}
