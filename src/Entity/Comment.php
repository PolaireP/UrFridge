<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?commentary $commentary = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $writer = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentary(): ?commentary
    {
        return $this->commentary;
    }

    public function setCommentary(?commentary $commentary): static
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getWriter(): ?user
    {
        return $this->writer;
    }

    public function setWriter(?user $writer): static
    {
        $this->writer = $writer;

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

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function setCommentId(int $commentId): static
    {
        $this->commentId = $commentId;

        return $this;
    }
}
