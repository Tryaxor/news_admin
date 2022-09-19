<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body;

    #[ORM\Column(type: 'boolean')]
    private ?bool $validated;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeImmutable $created_at;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeImmutable $updated_at;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'viewed_articles')]
    private Collection $viewed;

    public function __construct(
        string $title,
        string $body,
        bool $validated,
        DateTimeInterface $created_at,
        DateTimeInterface $updated_at
    )
    {
        $this->$title = $title;
        $this->$body = $body;
        $this->$validated = $validated;
        $this->$created_at = $created_at;
        $this->$updated_at = $updated_at;
        $this->viewed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): void
    {
        $this->validated = $validated;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return Collection<int, User>
     */
    public function getViewedBy(): Collection
    {
        return $this->viewed;
    }

    public function addViewedBy(User $viewedBy): void
    {
        if (!$this->viewed->contains($viewedBy)) {
            $this->viewed->add($viewedBy);
        }
    }

    public function removeViewedBy(User $viewedBy): void
    {
        $this->viewed->removeElement($viewedBy);
    }
}