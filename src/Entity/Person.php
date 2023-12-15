<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\Table(name: '`person`')]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $password;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $avatar;

    #[ORM\OneToOne(inversedBy: 'owner', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inventory $inventory = null;

    #[ORM\OneToMany(mappedBy: 'writer', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'follower')]
    private Collection $favorites;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(Inventory $inventory): static
    {
        // set the owning side of the relation if necessary
        if ($inventory->getOwner() !== $this) {
            $inventory->setOwner($this);
        }

        $this->inventory = $inventory;

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
            $comment->setWriter($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getWriter() === $this) {
                $comment->setWriter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Recipe $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->addFollower($this);
        }

        return $this;
    }

    public function removeFavorite(Recipe $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            $favorite->removeFollower($this);
        }

        return $this;
    }
}
