<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {



            $customer = new Student();
            $customer->setName("Samination");
            $customer->setGrade(12);
            $customer->setEmail("Sami.Krit@esprit.tn");
        $customer1 = new Student();
        $customer1->setName("Hadi");
        $customer1->setGrade(14);
        $customer1->setEmail("Hadi.Aloui@esprit.tn");

            $manager->persist($customer);
        $manager->persist($customer1);


        $manager->flush();
    }
}
