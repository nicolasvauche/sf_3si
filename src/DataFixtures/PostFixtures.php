<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $post = new Post();
        $post->setCategory($this->getReference('category1'))
            ->setTitle('Mon premier article')
            ->setIsOnline(true);
        $manager->persist($post);

        $post = new Post();
        $post->setCategory($this->getReference('category1'))
            ->setTitle('Mon deuxième article')
            ->setIsOnline(true);
        $manager->persist($post);

        $post = new Post();
        $post->setCategory($this->getReference('category2'))
            ->setTitle('Mon troisième article')
            ->setIsOnline(true);
        $manager->persist($post);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
