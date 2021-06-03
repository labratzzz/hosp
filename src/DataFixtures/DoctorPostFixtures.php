<?php

namespace App\DataFixtures;

use App\Entity\DoctorPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DoctorPostFixtures extends Fixture
{
    const POSTS = [
        'Терапевт',
        'Оториноларинголог',
        'Хирург',
        'Гинеколог',
        'Уролог',
        'Педиатр',
        'Психиатр',
        'Психолог'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::POSTS as $item) {
            $doctorPost = new DoctorPost();
            $doctorPost->setName($item);
            $manager->persist($doctorPost);
        }
        $manager->flush();
    }
}
