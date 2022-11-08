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
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
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
}
