<?php

namespace App\Controller;

use App\Entity\TVA;
use App\Form\TVAType;
use App\Repository\TVARepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tva')]
class AdminTvaController extends AbstractController
{
    #[Route('/', name: 'app_admin_tva_index', methods: ['GET'])]
    public function index(TVARepository $tVARepository): Response
    {
        return $this->render('admin_tva/index.html.twig', [
            't_v_as' => $tVARepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tva_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TVARepository $tVARepository): Response
    {
        $tVA = new TVA();
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tVARepository->save($tVA, true);

            return $this->redirectToRoute('app_admin_tva_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tva/new.html.twig', [
            't_v_a' => $tVA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tva_show', methods: ['GET'])]
    public function show(TVA $tVA): Response
    {
        return $this->render('admin_tva/show.html.twig', [
            't_v_a' => $tVA,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tva_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TVA $tVA, TVARepository $tVARepository): Response
    {
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tVARepository->save($tVA, true);

            return $this->redirectToRoute('app_admin_tva_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tva/edit.html.twig', [
            't_v_a' => $tVA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tva_delete', methods: ['POST'])]
    public function delete(Request $request, TVA $tVA, TVARepository $tVARepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tVA->getId(), $request->request->get('_token'))) {
            $tVARepository->remove($tVA, true);
        }

        return $this->redirectToRoute('app_admin_tva_index', [], Response::HTTP_SEE_OTHER);
    }
}
