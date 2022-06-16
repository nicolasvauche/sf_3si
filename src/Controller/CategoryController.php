<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/blog/categorie', name: 'app_blog_category_')]
#[isGranted('ROLE_USER')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/details/{slug}', name: 'show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    #[isGranted('ROLE_ADMIN')]
    public function add(Request $request, CategoryRepository $categoryRepository, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            /** @var UploadedFile $categoryMediaFile */
            $categoryMediaFile = $form->get('media')->getData();

            if ($categoryMediaFile) {
                $fileName = $fileUploader->upload($categoryMediaFile, $this->getParameter('category_media_directory'), $slugger->slug($category->getName()));
                $category->setMedia($fileName);
            }
            $categoryRepository->add($category, true);

            return $this->redirectToRoute('app_blog_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/add.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{slug}', name: 'edit')]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $categoryMediaFile */
            $categoryMediaFile = $form->get('media')->getData();
            if ($categoryMediaFile) {
                if ($category->getMedia()) {
                    $fileUploader->delete($this->getParameter('category_media_directory'), $category->getMedia());
                }
                $fileName = $fileUploader->upload($categoryMediaFile, $this->getParameter('category_media_directory'), $slugger->slug($category->getName()));
                $category->setMedia($fileName);
            }
            $categoryRepository->add($category, true);
            return $this->redirectToRoute('app_blog_category_show', ['slug' => strtolower($slugger->slug($category->getName()))], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository, FileUploader $fileUploader): Response
    {
        $fileUploader->delete($this->getParameter('category_media_directory'), $category->getMedia());
        $categoryRepository->remove($category, true);

        return $this->redirectToRoute('app_blog_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
