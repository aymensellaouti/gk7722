<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
