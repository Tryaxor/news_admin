<?php

namespace App\Service;

// use App\Entity\Author;
// use App\Entity\Book;
use App\Entity\Article;
use App\Entity\User;
// use App\Repository\AuthorRepository;
// use App\Repository\BookRepository;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;

use Doctrine\Common\Collections\Collection;

class QueryService
{
    public function __construct(
        private UserRepository $authorRepository,
        private ArticleRepository   $userRepository,
    ) {
    }

    // public function findAuthor(int $authorId): ?Author
    // {
    //     return $this->authorRepository->find($authorId);
    // }

    // public function getAllAuthors(): array
    // {
    //     return $this->authorRepository->findAll();
    // }

    public function findBooksByAuthor(string $userName): Collection
    {
        return $this
            ->authorRepository
            ->findOneBy(['name' => $userName])
            ->getArticles();
    }

    public function findAllArticles(): array
    {
        return $this->articleRepository->findAll();
    }

    public function findArticleById(int $ArticleId): ?Article
    {
        return $this->articleRepository->find($ArticleId);
    }
}
