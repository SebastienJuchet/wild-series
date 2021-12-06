<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Service\Slugify;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{program}/season/{season}/episode/{episode}", name="episode_show")
     */
    public function showEpisodes(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

}