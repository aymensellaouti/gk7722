<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecondController extends AbstractController
{
    #[Route('/firste/{age}/{nom}', name: 'app_second')]
    public function index($nom, $age): Response
    {
/*         $name = 'aymen';
        $message = "Bonjour $name";
 */     
        if ($age>65) {
            return $this->redirectToRoute('app_first');
        }
        return $this->render('second/index.html.twig', [
            'nom' => $nom,
            'age' => $age,
        ]);
    }

    #[Route('cv/{name}/{firstname}/{age}/{section}', name:'cv')]
    public function cv($name, $firstname, $age, $section) {
       return $this->render('second/cv.html.twig', [
        'name' => $name,
        'firstname' => $firstname,
        'age' => $age,
        'section' => $section
       ]);
    }
}
