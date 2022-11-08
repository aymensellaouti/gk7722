<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController 
{
    #[Route('/first', name: 'app_first')]
    public function first() {
        $response = new Response('<p>Cc GK</p>');
        return $response;
    }        
    #[Route('/first/{age}/{nom}/cc', name: 'app_first2')]
    public function first2($age, $nom) {
        $response = new Response("<p>Cc GK je suis $nom j'ai $age ans</p>");
        return $response;
    }
}

