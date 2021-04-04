<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    // public const USER = 'USER';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(PersistenceObjectManager $manager)
    {
        // Create Yohann Admin
        $yohann = new User();
        $yohann->setEmail('yohanndurand76@gmail.com');
        $yohann->setPassword($this->passwordEncoder->encodePassword($yohann,'dev0000'));
        $yohann->setRoles(["ROLE_ADMIN"]);
        $manager->persist($yohann);
                
        $manager->flush();
    }
}
