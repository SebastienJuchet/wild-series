<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/show/{category}", name="show")
     */
    public function show(Category $category): Response
    {
        if (!$category) {
            throw $this->createNotFoundException('Le nom de catégorie ' . $category . 'n\'existe pas');
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findByCategory($category, ['id' => 'DESC'], 3);
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $doctrine->getManager()->persist($category);
            $doctrine->getManager()->flush();

            return $this->redirectToRoute("category_index");
        }
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }
}