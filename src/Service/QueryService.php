<?php

namespace App\Service;

// use App\Entity\Author;
// use App\Entity\Book;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;

use Doctrine\Common\Collections\Collection;

class QueryService
{
    public function __construct(
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository,
    ) {
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
