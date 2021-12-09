<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{/**
 * @Route("/", name="index")
 */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $actors = $entityManager->getRepository(Actor::class)->findAll();

        return $this->renderForm('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    /**
     * @Route("/new/", name="new")
     */
    public function new(Request $request,ManagerRegistry $doctrine, Slugify $slugify): Response
    {
        $entityManager = $doctrine->getManager();
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($form->getData()->getName());
            $actor->setSlug($slug);
            $actor = $form->getData();
            $entityManager->persist($actor);
            $entityManager->flush();

            return $this->redirectToRoute('actor_index');
        }

        return $this->renderForm('actor/add.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{actor}", name="delete", methods={"GET"})
     */
    public function delete(Request $request, Actor $actor, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($actor);
        $entityManager->flush();

        return $this->redirectToRoute('actor_index');
    }

    /**
     * @Route("/{slug}", name="show")
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
