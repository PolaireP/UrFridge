<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $stepTitle = null;

    #[ORM\Column(length: 400)]
    private ?string $stepDescription = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepId(): ?int
    {
        return $this->stepId;
    }

    public function setStepId(int $stepId): static
    {
        $this->stepId = $stepId;

        return $this;
    }

    public function getStepTitle(): ?string
    {
        return $this->stepTitle;
    }

    public function setStepTitle(string $stepTitle): static
    {
        $this->stepTitle = $stepTitle;

        return $this;
    }

    public function getStepDescription(): ?string
    {
        return $this->stepDescription;
    }

    public function setStepDescription(string $stepDescription): static
    {
        $this->stepDescription = $stepDescription;

        return $this;
    }

    public function getRecipe(): ?recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}
