<?php

namespace App\Controller;

use App\Entity\Hobby;
use App\Form\HobbyType;
use App\Repository\HobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hobby')]
class HobbyController extends AbstractController
{
    #[Route('/', name: 'app_hobby_index', methods: ['GET'])]
    public function index(HobbyRepository $hobbyRepository): Response
    {
        return $this->render('hobby/index.html.twig', [
            'hobbies' => $hobbyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hobby_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HobbyRepository $hobbyRepository): Response
    {
        $hobby = new Hobby();
        $form = $this->createForm(HobbyType::class, $hobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hobbyRepository->save($hobby, true);

            return $this->redirectToRoute('app_hobby_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hobby/new.html.twig', [
            'hobby' => $hobby,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hobby_show', methods: ['GET'])]
    public function show(Hobby $hobby): Response
    {
        return $this->render('hobby/show.html.twig', [
            'hobby' => $hobby,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hobby_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hobby $hobby, HobbyRepository $hobbyRepository): Response
    {
        $form = $this->createForm(HobbyType::class, $hobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hobbyRepository->save($hobby, true);

            return $this->redirectToRoute('app_hobby_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hobby/edit.html.twig', [
            'hobby' => $hobby,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hobby_delete', methods: ['POST'])]
    public function delete(Request $request, Hobby $hobby, HobbyRepository $hobbyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hobby->getId(), $request->request->get('_token'))) {
            $hobbyRepository->remove($hobby, true);
        }

        return $this->redirectToRoute('app_hobby_index', [], Response::HTTP_SEE_OTHER);
    }
}
