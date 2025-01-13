<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $agency1 = new Agency();
        $agency1->setName('Rental Paris Center')
            ->setAddress('123 Avenue des Champs-Élysées')
            ->setCity('Paris')
            ->setPostalCode('75008')
            ->setPhone('+33 1 23 45 67 89')
            ->setEmail('paris.center@rental.com')
            ->setLatitude(48.8566)
            ->setLongitude(2.3522)
            ->setOpeningHours([
                'monday' => ['09:00-19:00'],
                'tuesday' => ['09:00-19:00'],
                'wednesday' => ['09:00-19:00'],
                'thursday' => ['09:00-19:00'],
                'friday' => ['09:00-19:00'],
                'saturday' => ['10:00-18:00'],
                'sunday' => ['closed']
            ]);
            $agency2 = new Agency();
            $agency2->setName('Rental Lyon Downtown')
                ->setAddress('45 Rue de la République')
                ->setCity('Lyon')
                ->setPostalCode('69002')
                ->setPhone('+33 4 78 90 12 34')
                ->setEmail('lyon.downtown@rental.com')
                ->setLatitude(45.7578)
                ->setLongitude(4.8320)
                ->setOpeningHours([
                    'monday' => ['08:30-18:30'],
                    'tuesday' => ['08:30-18:30'],
                    'wednesday' => ['08:30-18:30'],
                    'thursday' => ['08:30-18:30'],
                    'friday' => ['08:30-18:30'],
                    'saturday' => ['09:00-17:00'],
                    'sunday' => ['closed']
                ]);
                $manager->persist($agency1);
                $manager->persist($agency2);
                $manager->flush();
    }
}
