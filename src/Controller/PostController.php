<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'app_blog_post_')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findBy([], ['updatedAt' => 'DESC']),
        ]);
    }
}
