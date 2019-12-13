<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Professionnel', 'Personnel', 'Important'];
        # tableau pour enregistrer chaque objet de type Category
        $tabCategories = [];
        # boucle pour créer autant d'objet que de catégories dans la liste
        foreach ($categories as $cat) {
            $category = new Category();
            $category ->setName($cat);
            $manager->persist($category);
            array_push($tabCategories, $category);
        }
     #instance de type todo
     $uneTodo = new Todo();
     $uneTodo
        ->setTitle('Initialiser la todo')
        ->setContent('Alimenter la base de données  avec un 1er enregistrement')
        ->setTodoFor(new \DateTime('Europe/paris'))
        ->setCategory($tabCategories[0]);
        # enregistrer l'objet
        $manager->persist($uneTodo);
        # on finalise la fin de requêtes 
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}