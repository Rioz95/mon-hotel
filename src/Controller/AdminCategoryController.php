<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AdminCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class AdminCategoryController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render(
            'admin/category/index.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    #[Route('/admin/category/new', name: 'admin_category_new')]
    public function create(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();

        $form = $this->createForm(AdminCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "La categorie <strong>{$category->getName()}</strong> a été bien ajouté !"
            );

            return $this->redirectToRoute('admin_category');
        }

        return $this->render(
            'admin/category/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/admin/category/{id}/edit', name: 'admin_category_edit')]
    public function edit(HttpFoundationRequest $request, EntityManagerInterface $entityManager, Category $category): Response
    {
        $form = $this->createForm(AdminCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "La categorie a été bien modifié !"
            );

            return $this->redirectToRoute('admin_category');
        }

        return $this->render(
            'admin/category/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
    #[Route('/admin/category/{id}/delete', name: 'admin_category_delete')]
    public function delete(HttpFoundationRequest $request, EntityManagerInterface $entityManager, Category $category): Response
    {

        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash(
            'success',
            "La categorie <strong>{$category->getName()}</strong> a été bien supprimer !"
        );

        return $this->redirectToRoute('admin_category');
    }
}
