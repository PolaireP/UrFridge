<?php

namespace App\Entity;

use App\Repository\RecipePhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipePhotoRepository::class)]
class RecipePhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $recipePhoto = null;

    #[ORM\OneToMany(mappedBy: 'recipePhoto', targetEntity: recipe::class)]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipePhoto()
    {
        return $this->recipePhoto;
    }

    public function setRecipePhoto($recipePhoto): static
    {
        $this->recipePhoto = $recipePhoto;

        return $this;
    }

    /**
     * @return Collection<int, recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setRecipePhoto($this);
        }

        return $this;
    }

    public function removeRecipe(recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getRecipePhoto() === $this) {
                $recipe->setRecipePhoto(null);
            }
        }

        return $this;
    }
}
