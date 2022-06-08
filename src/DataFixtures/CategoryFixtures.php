<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Une rubrique')
            ->setIsOnline(true);
        $manager->persist($category);
        $this->setReference('category1', $category);

        $category = new Category();
        $category->setName('Une autre rubrique')
            ->setIsOnline(true);
        $manager->persist($category);

        $manager->flush();
        $this->setReference('category2', $category);
    }

    public function getOrder(): int
    {
        return 2;
    }
}
