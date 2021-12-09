<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{   private $passhash;
    public function __construct(UserPasswordHasherInterface $passhash)
    {
        $this->passhash = $passhash;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@gmail.com');
        $user->setRoles(['ROLE_CONTRIBUTOR']);
        $user->setPassword($this->passhash->hashPassword($user,'azerty'));
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@gmail.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword($this->passhash->hashPassword($userAdmin, 'azerty'));
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
