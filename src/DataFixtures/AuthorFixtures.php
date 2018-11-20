<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $authors = [
            ["J.K", "Rowling"],
            ["Gustave", "Flaubert"],
            ["René", "Goscinny"],
            ["Emile", "Zola"]
        ];
        foreach ($authors as $author) {
            $aut = new Author();
            $aut->setFirstname($author[0]);
            $aut->setLastname($author[1]);
            $manager->persist($aut);
            $this->setReference("author-" . strtolower($author[1]), $aut);
        }
        $manager->flush();
    }
}
