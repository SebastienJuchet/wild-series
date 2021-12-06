<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public $slugify;
    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 14; $i++) {
            $episode = new Episode();
            $episode->setNumber($i);
            $episode->setTitle('Episode n°' . $i);
            $episode->setSynopsis('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $episode->setSeason($this->getReference('season_1' . $i));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $manager->persist($episode);
        }

        for ($i = 1; $i < 14; $i++) {
            $episode = new Episode();
            $episode->setNumber($i);
            $episode->setTitle('Episode n°' . $i);
            $episode->setSynopsis('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $episode->setSeason($this->getReference('season_2' . $i));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $manager->persist($episode);
        }

        for ($i = 1; $i < 14; $i++) {
            $episode = new Episode();
            $episode->setNumber($i);
            $episode->setTitle('Episode n°' . $i);
            $episode->setSynopsis('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $episode->setSeason($this->getReference('season_3' . $i));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $manager->persist($episode);
        }

        for ($i = 1; $i < 14; $i++) {
            $episode = new Episode();
            $episode->setNumber($i);
            $episode->setTitle('Episode n°' . $i);
            $episode->setSynopsis('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $episode->setSeason($this->getReference('season_4' . $i));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
