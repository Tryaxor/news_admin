<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use App\Entity\Article;

class ArticlesFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void

    {
        for ($i = 0; $i < 100; $i++) {
            $manager->persist(
                $this->getFakeArticle()
            );
        }
        $manager->flush();
    }

    // public function load(ObjectManager $manager): void 
    // {
    //     for ($i = 0; $i < 100; $i++) {
    //         $manager->persist(
    //             $this->getFakeBook()
    //         );
    //     }
    //     $manager->flush();
    // }

    private function getFakeArticle(): Article
    {
        // $genres = ['Action', 'Comedy', 'Romance', 'Sci-fi', 'Programming'];

        return new Article(
            $this->faker->title(),
            $this->faker->sentences(5, true),
            $this->faker->boolean(),
            $this->faker->date_create(),
            $this->faker->date_create(),
            $this->getReference(AuthorFixtures::REFERENCE),

        );
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
        ];
    }
}
