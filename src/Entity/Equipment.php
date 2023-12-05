<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $equipmentName = null;

    #[ORM\Column(length: 400, nullable: true)]
    private ?string $equipmentLink = null;

    #[ORM\ManyToMany(targetEntity: recipe::class, inversedBy: 'equipments')]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipmentName(): ?string
    {
        return $this->equipmentName;
    }

    public function setEquipmentName(string $equipmentName): static
    {
        $this->equipmentName = $equipmentName;

        return $this;
    }

    public function getEquipmentLink(): ?string
    {
        return $this->equipmentLink;
    }

    public function setEquipmentLink(?string $equipmentLink): static
    {
        $this->equipmentLink = $equipmentLink;

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
}
