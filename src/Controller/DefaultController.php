<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('default/index.html.twig',
            [
                'postsRecent' => $postRepository->findBy(['isOnline' => true], ['updatedAt' => 'DESC', 'createdAt' => 'DESC', 'id' => 'DESC'], 6),
            ]);
    }

    #[Route('/contactez-nous', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }
}
