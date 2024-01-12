<?php

namespace App\Entity;

use App\Repository\AllergenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergenRepository::class)]
class Allergen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $allergenName = null;

    #[ORM\Column(length: 400, nullable: true)]
    private ?string $allergenDescription = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'allergens')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAllergenName(): ?string
    {
        return $this->allergenName;
    }

    public function setAllergenName(string $allergenName): static
    {
        $this->allergenName = $allergenName;

        return $this;
    }

    public function getAllergenDescription(): ?string
    {
        return $this->allergenDescription;
    }

    public function setAllergenDescription(?string $allergenDescription): static
    {
        $this->allergenDescription = $allergenDescription;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }
}
