<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public $slugify;
    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        $cat = $this->getReference('Category_4');
        $program = new Program();
        $program->setCategory($cat);
        $program->setTitle('La casa de papel');
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program->addActor($this->getReference('actor_' . $i));
        }
        $program->setOwner($this->getReference('user'));
        $program->setSlug($this->slugify->generate($program->getTitle()));
        $program->setSummary('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium 
        doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae 
        vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia 
        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum 
        quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et 
        dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis 
        suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea 
        voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');
        $this->addReference('program_1', $program);
        $manager->persist($program);

        $program2 = new Program();
        $program2->setCategory($this->getReference('Category_0'));
        $program2->setTitle('American horror stories');
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program2->addActor($this->getReference('actor_' . $i));
        }
        $program2->setOwner($this->getReference('user'));
        $program2->setSlug($this->slugify->generate($program2->getTitle()));

        $program2->setSummary('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');
        $this->addReference('program_2', $program2);
        $manager->persist($program2);

        $program3 = new Program();
        $program3->setCategory($this->getReference('Category_4'));
        $program3->setTitle('Breaking bad');
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program3->addActor($this->getReference('actor_' . $i));
        }
        $program3->setOwner($this->getReference('admin'));
        $program3->setSlug($this->slugify->generate($program3->getTitle()));
        $program3->setSummary('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');
        $this->addReference('program_3', $program3);
        $manager->persist($program3);

        $program4 = new Program();
        $program4->setCategory($this->getReference('Category_4'));
        $program4->setTitle('Prison Break');
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program4->addActor($this->getReference('actor_' . $i));
        }
        $program4->setOwner($this->getReference('user'));
        $program4->setSlug($this->slugify->generate($program4->getTitle()));
        $program4->setSummary('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');
        $this->addReference('program_4', $program4);
        $manager->persist($program4);

        $program5 = new Program();
        $program5->setCategory($this->getReference('Category_5'));
        $program5->setTitle('Hunter X Hunter');
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program5->addActor($this->getReference('actor_' . $i));
        }
        $program5->setOwner($this->getReference('admin'));
        $program5->setSlug($this->slugify->generate($program5->getTitle()));
        $program5->setSummary('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');
        $this->addReference('program_5', $program5);
        $manager->persist($program5);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
