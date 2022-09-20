<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

class MutationService
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}

    public function createArticle(array $articleDetails): Article
    {
        $user = $this->manager->getRepository(User::class)->find($articleDetails['user_id']);
        $article = new Article(
            $articleDetails['title'],
            $articleDetails['body'],
            $articleDetails['validated'],
            new DateTime(),
            new DateTime(),
            $user
        );

        $this->manager->persist($article);
        $this->manager->flush();

        return $article;
    }

    public function updateArticle(int $articleId, array $newDetails): Article
    {
        $article = $this->manager->getRepository(Article::class)->find($articleId);

        if (is_null($article)) {
            throw new Error("Could not find article for specified ID");
        }

        foreach ($newDetails as $property => $value) {
            $article->$property = $value;
        }

        $this->manager->persist($article);
        $this->manager->flush();

        return $article;
    }
}