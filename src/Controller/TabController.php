<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tableau/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes = [];
        for ($i = 0; $i < $nb ; $i++) {
            $notes[]= rand(0,20);
        }
        /* créer un tableau de nb notes */
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }
}
