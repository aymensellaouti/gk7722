<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionInterface $session ): Response
    {
        /* 
        1- vérifier si la session est nouvelle ou pas (en vérifiant l'existance d'une variable stocké dedans)
        2- Cas 1ere visite
            2-1 Crée un compteurVisite et l'initialiser à 1 et le mettre dans la session 
        3- Cas nème visite
            3-1 Incrémenter de 1         
        */
         if ($session->has('nbVisite')) {
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $session->set('nbVisite', $nbVisite);
         } 
         /* n'existe pas  */
         else {
            $this->addFlash('info', 'Bienvenu dans notre site');
            $session->set('nbVisite',1);
         } 
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
