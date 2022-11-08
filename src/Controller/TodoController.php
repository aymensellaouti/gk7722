<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'todo_list')]
    public function index(SessionInterface $session): Response
    {
        /* Est ce que la session contient la variable todos */
        /* Si elle ne contient pas donc le 1er accés */
        if (!$session->has('todos')) {
            /* On initialise le tableau de todo */
            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            /* On l'ajoute dans la session */
            $session->set('todos', $todos);
            $this->addFlash('info', 'Liste des todos initialisée avec succès');
        } else {
            $this->addFlash('info', 'Bienvenu à la liste des todos');
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/add/{name}/{description}', name: 'add_todo')]
    public function addTodo(SessionInterface $session, $name, $description): Response {
        /* Si le tableau de todo existe ou pas dans la session */
        if ($session->has('todos')) {
        /* Si ca existe */
            $todos = $session->get('todos'); 
            /* On vérifie que le todo de name $name n'existe pas */
            if (isset($todos[$name])) {
                /* Si ca existe message d'erreur*/
                $this->addFlash('error', "Le todo $name existe déjà");  
            } else {
                /* sinon on ajoute + message succès */
                $todos[$name] = $description;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $name a été ajouté avec succès :)");  
            }   
        } else {
        /* Si le tableau de todos n'existe pas on affiche un message d'erreur */    
        $this->addFlash('error', "La liste n'est pas encore initialisée");  
        }
        /* On redirige vers l'index qui sait déjà afficher la liste*/
        return $this->redirectToRoute('todo_list');
    }

    #[Route('/update/{name}/{description}', name: 'update_todo')]
    public function updateTodo(SessionInterface $session, $name, $description): Response {
        /* Si le tableau de todo existe ou pas dans la session */
        if ($session->has('todos')) {
        /* Si ca existe */
            $todos = $session->get('todos'); 
            /* On vérifie que le todo de name $name existe */
            if (!isset($todos[$name])) {
                /* Si ca existe message d'erreur*/
                $this->addFlash('error', "Le todo $name n'existe déjà");  
            } else {
                /* sinon on met à jour + message succès */
                $todos[$name] = $description;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $name a été mis à jour avec succès :)");  
            }   
        } else {
        /* Si le tableau de todos n'existe pas on affiche un message d'erreur */    
        $this->addFlash('error', "La liste n'est pas encore initialisée");  
        }
        /* On redirige vers l'index qui sait déjà afficher la liste*/
        return $this->redirectToRoute('todo_list');
    }

    #[Route('/delete/{name}', name: 'delete_todo')]
    public function deleteTodo(SessionInterface $session, $name): Response {
        /* Si le tableau de todo existe ou pas dans la session */
        if ($session->has('todos')) {
        /* Si ca existe */
            $todos = $session->get('todos'); 
            /* On vérifie que le todo de name $name n'existe pas */
            if (!isset($todos[$name])) {
                /* Si ca existe message d'erreur*/
                $this->addFlash('error', "Le todo $name n'existe pas");  
            } else {
                /* sinon on ajoute + message succès */
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $name a été supprimé avec succès :)");  
            }   
        } else {
        /* Si le tableau de todos n'existe pas on affiche un message d'erreur */    
        $this->addFlash('error', "La liste n'est pas encore initialisée");  
        }
        /* On redirige vers l'index qui sait déjà afficher la liste*/
        return $this->redirectToRoute('todo_list');
    }

}
