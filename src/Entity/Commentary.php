<?php

namespace App\Entity;

use App\Repository\CommentaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaryRepository::class)]
class Commentary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 400)]
    private ?string $commentaryContent = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $commentaryPubDate = null;

    #[ORM\OneToMany(mappedBy: 'commentary', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaryId(): ?int
    {
        return $this->commentaryId;
    }

    public function setCommentaryId(int $commentaryId): static
    {
        $this->commentaryId = $commentaryId;

        return $this;
    }

    public function getCommentaryContent(): ?string
    {
        return $this->commentaryContent;
    }

    public function setCommentaryContent(?string $commentaryContent): static
    {
        $this->commentaryContent = $commentaryContent;

        return $this;
    }

    public function getCommentaryPubDate(): ?\DateTimeInterface
    {
        return $this->commentaryPubDate;
    }

    public function setCommentaryPubDate(\DateTimeInterface $commentaryPubDate): static
    {
        $this->commentaryPubDate = $commentaryPubDate;

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
            $comment->setCommentary($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommentary() === $this) {
                $comment->setCommentary(null);
            }
        }

        return $this;
    }
}
