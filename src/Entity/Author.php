<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gr = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGr(): ?string
    {
        return $this->gr;
    }

    public function setGr(string $gr): self
    {
        $this->gr = $gr;

        return $this;
    }
}
