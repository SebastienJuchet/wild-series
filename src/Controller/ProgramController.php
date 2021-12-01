<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/{id}/", name="show", methods="GET", requirements={"id"="\d{1,}"})
     */
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $program = $em->getRepository(Program::class)
            ->findOneBy(['id' => $id], null, 3);
        $seasons = $em->getRepository(Season::class)->findBy(['program' => $id]);

        if (!$program) {
            throw $this->createNotFoundException('Le program avec l\'id: ' . $id . 'n\'existe pas!');
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{programId}/season/{seasonId}/", name="season_show")
     */
    public function showSeason(int $programId, int $seasonId, EntityManagerInterface $em)
    {
        $program = $em->getRepository(Program::class)->findOneById($programId);
        $season = $em->getRepository(Season::class)->findOneById($seasonId);
        $episodes = $em->getRepository(Episode::class)->findBy(['season' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);
    }
}