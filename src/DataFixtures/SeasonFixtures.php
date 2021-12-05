<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 15; $i++) {
            $season = new Season();
            $season->setNumber($i);
            $season->setYear(2000 + $i);
            $season->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            );
            $season->setProgram($this->getReference('program_1'));
            $this->addReference('season_1' . $i, $season);
            $manager->persist($season);
        }

        for ($i = 1; $i < 15; $i++) {
            $season2 = new Season();
            $season2->setNumber($i);
            $season2->setYear(2000 + $i);
            $season2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            );
            $season2->setProgram($this->getReference('program_2'));
            $this->addReference('season_2' . $i, $season2);
            $manager->persist($season2);
        }

        for ($i = 1; $i < 15; $i++) {
            $season3 = new Season();
            $season3->setNumber($i);
            $season3->setYear(2000 + $i);
            $season3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            );
            $season3->setProgram($this->getReference('program_3'));
            $this->addReference('season_3' . $i, $season3);
            $manager->persist($season3);
        }
        for ($i = 1; $i < 15; $i++) {
            $season4 = new Season();
            $season4->setNumber($i);
            $season4->setYear(2000 + $i);
            $season4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            );
            $season4->setProgram($this->getReference('program_4'));
            $this->addReference('season_4' . $i, $season4);
            $manager->persist($season4);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
