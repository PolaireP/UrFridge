<?php

namespace App\Entity;

use App\Factory\RecipeFactory;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $ingredientName = null;

    #[ORM\Column]
    private ?bool $countable = null;

    #[ORM\Column]
    private ?float $avgUnitWeight = null;

    #[ORM\Column(nullable: true)]
    private ?float $avgUnitVolume = null;

    #[ORM\Column]
    private ?float $kgPrice = null;

    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'ingredients')]
    private Collection $recipes;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: FridgeQuantity::class, orphanRemoval: true)]
    private Collection $quantities;

    #[ORM\ManyToMany(targetEntity: Allergen::class, mappedBy: 'ingredients')]
    private Collection $allergens;

    #[ORM\ManyToMany(targetEntity: IngredientType::class, mappedBy: 'ingredients')]
    private Collection $ingredientTypes;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: RecipeQuantity::class)]
    private Collection $recipeQuantities;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?IngredientPhoto $ingredient_photo = null;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->quantities = new ArrayCollection();
        $this->allergens = new ArrayCollection();
        $this->ingredientTypes = new ArrayCollection();
        $this->recipeQuantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredientName(): ?string
    {
        return $this->ingredientName;
    }

    public function setIngredientName(string $ingredientName): static
    {
        $this->ingredientName = $ingredientName;

        return $this;
    }

    public function isCountable(): ?bool
    {
        return $this->countable;
    }

    public function setCountable(bool $countable): static
    {
        $this->countable = $countable;

        return $this;
    }

    public function getAvgUnitWeight(): ?float
    {
        return $this->avgUnitWeight;
    }

    public function setAvgUnitWeight(float $avgUnitWeight): static
    {
        $this->avgUnitWeight = $avgUnitWeight;

        return $this;
    }

    public function getAvgUnitVolume(): ?float
    {
        return $this->avgUnitVolume;
    }

    public function setAvgUnitVolume(?float $avgUnitVolume): static
    {
        $this->avgUnitVolume = $avgUnitVolume;

        return $this;
    }

    public function getKgPrice(): ?float
    {
        return $this->kgPrice;
    }

    public function setKgPrice(float $kgPrice): static
    {
        $this->kgPrice = $kgPrice;

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
        }

        return $this;
    }

    public function removeRecipe(recipe $recipe): static
    {
        $this->recipes->removeElement($recipe);

        return $this;
    }

    /**
     * @return Collection<int, Quantity>
     */
    public function getQuantities(): Collection
    {
        return $this->quantities;
    }

    public function addQuantity(Quantity $quantity): static
    {
        if (!$this->quantities->contains($quantity)) {
            $this->quantities->add($quantity);
            $quantity->setIngredient($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $quantity): static
    {
        if ($this->quantities->removeElement($quantity)) {
            // set the owning side to null (unless already changed)
            if ($quantity->getIngredient() === $this) {
                $quantity->setIngredient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Allergen>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergen $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
            $allergen->addIngredient($this);
        }

        return $this;
    }

    public function removeAllergen(Allergen $allergen): static
    {
        if ($this->allergens->removeElement($allergen)) {
            $allergen->removeIngredient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, IngredientType>
     */
    public function getIngredientTypes(): Collection
    {
        return $this->ingredientTypes;
    }

    public function addIngredientType(IngredientType $ingredientType): static
    {
        if (!$this->ingredientTypes->contains($ingredientType)) {
            $this->ingredientTypes->add($ingredientType);
            $ingredientType->addIngredient($this);
        }

        return $this;
    }

    public function removeIngredientType(IngredientType $ingredientType): static
    {
        if ($this->ingredientTypes->removeElement($ingredientType)) {
            $ingredientType->removeIngredient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeQuantity>
     */
    public function getRecipeQuantities(): Collection
    {
        return $this->recipeQuantities;
    }

    public function addRecipeQuantity(RecipeQuantity $recipeQuantity): static
    {
        if (!$this->recipeQuantities->contains($recipeQuantity)) {
            $this->recipeQuantities->add($recipeQuantity);
            $recipeQuantity->setIngredient($this);
        }

        return $this;
    }

    public function removeRecipeQuantity(RecipeQuantity $recipeQuantity): static
    {
        if ($this->recipeQuantities->removeElement($recipeQuantity)) {
            // set the owning side to null (unless already changed)
            if ($recipeQuantity->getIngredient() === $this) {
                $recipeQuantity->setIngredient(null);
            }
        }

        return $this;
    }

    public function getIngredientPhoto(): ?IngredientPhoto
    {
        return $this->ingredient_photo;
    }

    public function setIngredientPhoto(?IngredientPhoto $ingredient_photo): static
    {
        $this->ingredient_photo = $ingredient_photo;

        return $this;
    }
}
