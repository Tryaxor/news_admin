<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AuthorFixtures extends Fixture implements OrderedFixtureInterface
{

    public const REFERENCE = 'AUTHORS_REFERENCE';

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $manager->persist(
                $this->getFakeAuthor()
            );
        }

        $referenceAuthor = $this->getFakeAuthor();
        $this->addReference(self::REFERENCE, $referenceAuthor);

        $manager->persist($referenceAuthor);
        $manager->flush();
    }

    private function getFakeAuthor(): User
    {
        return new User(
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->dateTime(),
            $this->faker->dateTime(),
            $this->faker->boolean(),
            $this->faker->boolean()
        );
    }

    public function getOrder(): int
    {
        return 1; // smaller means sooner
    }
}
