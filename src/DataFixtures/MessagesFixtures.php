<?php

namespace App\DataFixtures;

use App\Entity\Messages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MessagesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 50; $i++) {
            $message = new Messages();
            $message->setAuthor($faker->firstName . ' ' . $faker->lastName)
                    ->setContent($faker->sentence($faker->numberBetween(5, 20), true). ' '.
                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
                        $faker->sentence($faker->numberBetween(5, 20), true))
                    ->setCreation($faker->dateTime('now'));
            $manager->persist($message);
        }

        $manager->flush();
    }
}
