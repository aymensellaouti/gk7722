<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Node\Expression\Test\NullTest;

class PersonneController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        $repository = $this->doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        $stats = $repository->findAvgAndNumberPersonne();
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'stats' => $stats
        ]);
    }

    #[Route('/personne/edit/{id?0}', name: 'edit_personne')]
    public function edit(Request $request, Personne $personne = null): Response
    {   /* Pour récupérer le Request on utilise l'injection au niveau des paramè™ 
            Exemple ici edit( Request $request)
        */
        if (!$personne) 
            $personne = new Personne();
        /* $personne->setName('aymen'); */
        /* Créer notre formulaire */
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        /* isValid active la validation */
        if ($form->isSubmitted() && $form->isValid()) {
            /* Todo :  Ajouter la personne dans la base de données*/
            /* dd($personne); */
            $manager = $this->doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            return $this->redirectToRoute('app_personne');
        }
        return $this->render('personne/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/personne/{name}/{age}', name: 'add_personne')]
    public function addPersonne($name, $age): Response
    {
        $manager = $this->doctrine->getManager();
        $personne = new Personne();
        $personne->setName($name);
        $personne->setAge($age);
        /* Ajouter dans la transaction  */
        $manager->persist($personne);

        /* Exécuter la transaction */
        $manager->flush();
        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/personne/{id}/{name}/{age}', name: 'update_personne')]
    public function updatePersonne($name, $age, $id): Response
    {
        $manager = $this->doctrine->getManager();
        $repository = $this->doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);
        $personne->setName($name);
        $personne->setAge($age);
        /* Ajouter dans la transaction  */
        $manager->persist($personne);

        /* Exécuter la transaction */
        $manager->flush();
        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    } 
    
    #[Route('/personne/{id}', name: 'delete_personne')]
    public function deletePersonne($id): Response
    {
        $manager = $this->doctrine->getManager();
        $repository = $this->doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);
        /* Ajouter dans la transaction  */
        $manager->remove($personne);
        /* Exécuter la transaction */
        $manager->flush();
        return $this->redirectToRoute('app_personne');
    }
}
