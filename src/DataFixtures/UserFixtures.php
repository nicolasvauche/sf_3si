<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname('Nicolas')
            ->setLastname('Vauché')
            ->setEmail('nicolas.vauche@aliptic.net')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($user, 'nicolas'));
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Bob')
            ->setLastname('Marley')
            ->setEmail('bob@bob.bob')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->hasher->hashPassword($user, 'bob'));
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
