<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController 
{
    #[Route('/first', name: 'app_first')]
    public function first() {
        $response = new Response('<p>Cc GK</p>');
        return $response;
    }     
    #[Route('/heritage', name: 'app_heritage')]
    public function heritage() {
        return $this->render('first/heritage.html.twig');
    }        
    #[Route(
        '/first/test/{age<\d+>}/{nom?salah}', 
        name: 'app_first2',
/*         defaults:['nom' => 'salah', 'age' => 40] */    
    )]
    public function first2($age, $nom) {
        $response = new Response("<p>Cc GK je suis $nom j'ai $age ans</p>");
        return $response;
    }
}

