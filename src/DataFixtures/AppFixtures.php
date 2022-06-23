<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Person;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $age = [25,18,62,44,35];
        for($i = 0; $i < 20; $i++){
            $person = new Person();
            $faker = Factory::create();
            $person->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setAge($age[array_rand($age)])
                    ->setAddress($faker->address)
                    ->setEmail($faker->email);

        $manager->persist($person);
        }
        $manager->flush();
    }
}
