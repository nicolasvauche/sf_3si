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
            ->setContent("<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>")
            ->setIsOnline(true);
        $manager->persist($post);

        $post = new Post();
        $post->setCategory($this->getReference('category1'))
            ->setTitle('Mon deuxième article')
            ->setContent("<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &laquo;de Finibus Bonorum et Malorum&raquo; (The Extremes of Good and Evil) by Cicero, written in 45 BC.</p>")
            ->setIsOnline(false);
        $manager->persist($post);

        $post = new Post();
        $post->setCategory($this->getReference('category2'))
            ->setTitle('Mon troisième article')
            ->setContent("<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>")
            ->setIsOnline(true);
        $manager->persist($post);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
