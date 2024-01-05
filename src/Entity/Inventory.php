<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'inventory', cascade: ['persist', 'remove'])]
    private ?person $owner = null;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: FridgeQuantity::class, orphanRemoval: true)]
    private Collection $quantities;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'inventories')]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->quantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInventId(): ?int
    {
        return $this->inventId;
    }

    public function setInventId(int $inventId): static
    {
        $this->inventId = $inventId;

        return $this;
    }

    public function getOwner(): ?person
    {
        return $this->owner;
    }

    public function setOwner(person $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setInventories($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getInventories() === $this) {
                $recipe->setInventories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FridgeQuantity>
     */
    public function getQuantities(): Collection
    {
        return $this->quantities;
    }

    public function addQuantity(FridgeQuantity $quantity): static
    {
        if (!$this->quantities->contains($quantity)) {
            $this->quantities->add($quantity);
            $quantity->setInventory($this);
        }

        return $this;
    }

    public function removeQuantity(FridgeQuantity $quantity): static
    {
        if ($this->quantities->removeElement($quantity)) {
            // set the owning side to null (unless already changed)
            if ($quantity->getInventory() === $this) {
                $quantity->setInventory(null);
            }
        }

        return $this;
    }
}
