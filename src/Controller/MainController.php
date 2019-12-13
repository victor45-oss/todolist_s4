<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $menu_categories;

    function __construct( CategoryRepository $repo )
    {
        $this->menu_categories = $repo->findAll();
    }


    /**
     * Récuperer toutes les Todo
     * @Route("/", name="home")
     */


    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Todo::class);
        $todos = $repo->findAll();
        dump($todos);
        return $this->render('main/index.html.twig', [
            'todos' => $todos,
            'menu_categories' => $this->menu_categories
        ]);
    }

/**
 * @Route("/new", name="create_todo")
 */

 public function create(Request $request){

        $todo = new Todo();
        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $data = $form->getData(); // Recupere les données soumises
            // Sauvegarde en base de données ! 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
    
            return $this->redirectToRoute('home');
        }

            return $this->render('crud/create.html.twig', [
            'myform' => $form->createView(),
            'menu_categories' => $this->menu_categories
]);
}

/**
 * @Route("/edit/{id}", name="update_todo")
 */

public function update($id, Request $request) {
    // on a récupéré une todo existante dans la base de données avec son id
    $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
    $form = $this->createForm(TodoType::class, $todo);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        // je récupère la date d'aujourd'hui comme date de modification 
        $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $todo->setUpdatedAt($now);
        // j'enregistre en base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();
        // préparer un message 
        $this->addFlash('succes', 'La todo a été bien modifiée');
        // redirection
        return $this->redirectToRoute('home');
    }
        return $this->render('crud/update.html.twig',[
        'myform' => $form->createView(), 'menu_categories' => $this->menu_categories

    ]);
}

/**
 * @Route("delete/{id}", name="delete_todo")
 */

public function delete($id, request $request) {
    $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
    $em = $this->getDoctrine()->getManager();
    $em->remove($todo);
    $em->flush();
    //préparer un message en session limitée 
    $this->addFlash('alert','La todo a été bien supprimée');
    //redirection
    return $this->redirectToRoute('home');

}


/**
 * @Route("/todos/{id}", name="todo_category")
 */

public function todoByCategory($id, CategoryRepository $repo) {
    $category = $repo->find($id);
    $todos = $category->getTodos();
    return $this->render('main/index.html.twig', [
        'todos' => $category->$todos(),
        'menu_categories' => $this->menu_categories
    ]);
}


}




