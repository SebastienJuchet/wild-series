<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/program", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
    * @Route("/", name="index")
    */
    public function index(EntityManagerInterface $em): Response
    {
        $programs = $em->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig',[
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/new/", name="new")
     */
    public function new(Request $request, ManagerRegistry $doctrine, Slugify $slugify, MailerInterface $mailer): Response
    {
        $program = new Program();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $program = $form->getData();
            $entityManager->persist($program);
            $entityManager->flush();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('sebastien.juchet@gmail.com')
                ->subject('Nouvelle série')
                ->html($this->renderView('email/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($email);
            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}/", name="show", methods="GET")
     */
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException('Le program avec l\'id: ' . $program->getTitle() . 'n\'existe pas!');
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Program $program, Request $request, ManagerRegistry $doctrine): Response
    {
        if (!($this->getUser() == $program->getOwner())) {
            throw new AccessDeniedException('Seul celui qui a ajouté cette série peut la modifiée');
        }
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}/season/{seasonNumber}/", name="season_show")
     */
    public function showSeason(Program $program, Season $season, ManagerRegistry $doctrine)
    {
        $episodes = $doctrine->getRepository(Episode::class)->findBySeason($season);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route("/{slug}/season/{seasonNumber}/episode/{episode}", name="episode_show")
     */
    public function showEpisodes(Program $program, Season $season, Episode $episode, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setAutor($this->getUser());
            $comment->setEpisode($episode);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}/season/{seasonNumber}/episode/{episode}/comment/{comment}", name="comment_delete")
     */
    public function delete(Program $program, Season $season, Episode $episode, Comment $comment, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_index');
    }
}