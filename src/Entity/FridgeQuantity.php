<?php

namespace App\Entity;

use App\Repository\FridgeQuantityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FridgeQuantityRepository::class)]
class FridgeQuantity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'quantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inventory $inventory = null;

    #[ORM\ManyToOne(inversedBy: 'quantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredient $ingredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): static
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }
}
