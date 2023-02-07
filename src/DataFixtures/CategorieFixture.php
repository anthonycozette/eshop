<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieFixture extends Fixture
{

    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
        
    }
    
    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique',null, $manager);

        $this->createCategory('Ordinateurs', $parent, $manager);
        $this->createCategory('Ecrans', $parent, $manager);
        $this->createCategory('Souris', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categorie $parent = null, ObjectManager $manager)
    {
        $categorie = new Categorie();
        $categorie->setName($name);
        $categorie->setSlug($this->slugger->slug($categorie->getName())->lower());
        $categorie->setParent($parent);
        $manager->persist($categorie);

        $this->addReference('cat-' .$this->counter, $categorie);
        $this->counter++;

        return $categorie;
    }
}
