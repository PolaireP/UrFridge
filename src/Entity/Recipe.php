<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $recipeName = null;

    #[ORM\Column(length: 400)]
    private ?string $recipeDescription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $recipePubDate = null;

    #[ORM\Column]
    private ?bool $verified = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'favorites')]
    private Collection $follower;

    #[ORM\ManyToMany(targetEntity: Equipment::class, mappedBy: 'recipes')]
    private Collection $equipments;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'recipes')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private ?RecipePhoto $recipePhoto = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Step::class, orphanRemoval: true)]
    private Collection $steps;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'recipes')]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Inventory::class, inversedBy: 'recipes')]
    private Collection $inventories;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeQuantity::class)]
    private Collection $recipeQuantities;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private ?Person $recipeAuthor = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->follower = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->recipeQuantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): static
    {
        $this->recipeId = $recipeId;

        return $this;
    }

    public function getRecipeName(): ?string
    {
        return $this->recipeName;
    }

    public function setRecipeName(string $recipeName): static
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    public function getRecipeDescription(): ?string
    {
        return $this->recipeDescription;
    }

    public function setRecipeDescription(string $recipeDescription): static
    {
        $this->recipeDescription = $recipeDescription;

        return $this;
    }

    public function getRecipePubDate(): ?\DateTimeInterface
    {
        return $this->recipePubDate;
    }

    public function setRecipePubDate(\DateTimeInterface $recipePubDate): static
    {
        $this->recipePubDate = $recipePubDate;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): static
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, person>
     */
    public function getFollower(): Collection
    {
        return $this->follower;
    }

    public function addFollower(person $follower): static
    {
        if (!$this->follower->contains($follower)) {
            $this->follower->add($follower);
        }

        return $this;
    }

    public function removeFollower(person $follower): static
    {
        $this->follower->removeElement($follower);

        return $this;
    }

    public function getInventories(): ArrayCollection|Collection
    {
        return $this->inventories;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
            $equipment->addRecipe($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        if ($this->equipments->removeElement($equipment)) {
            $equipment->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addRecipe($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeRecipe($this);
        }

        return $this;
    }

    public function getRecipePhoto(): ?RecipePhoto
    {
        return $this->recipePhoto;
    }

    public function setRecipePhoto(?RecipePhoto $recipePhoto): static
    {
        $this->recipePhoto = $recipePhoto;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

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
            $ingredient->addRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeRecipe($this);
        }

        return $this;
    }

    public function addInventory(inventory $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
        }

        return $this;
    }

    public function removeInventory(inventory $inventory): static
    {
        $this->inventories->removeElement($inventory);

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
            $recipeQuantity->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeQuantity(RecipeQuantity $recipeQuantity): static
    {
        if ($this->recipeQuantities->removeElement($recipeQuantity)) {
            // set the owning side to null (unless already changed)
            if ($recipeQuantity->getRecipe() === $this) {
                $recipeQuantity->setRecipe(null);
            }
        }

        return $this;
    }

    public function getRecipeAuthor(): ?Person
    {
        return $this->recipeAuthor;
    }

    public function setRecipeAuthor(?Person $recipeAuthor): static
    {
        $this->recipeAuthor = $recipeAuthor;

        return $this;
    }
}
