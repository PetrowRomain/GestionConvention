<?php

namespace App\Controller;

use App\Entity\MaitreStage;
use App\Form\MaitreStageType;
use App\Repository\MaitreStageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/maitrestage")
 */
class MaitreStageController extends AbstractController
{
    /**
     * @Route("/", name="maitre_stage_index", methods={"GET"})
     */
    public function index(MaitreStageRepository $maitreStageRepository): Response
    {
        return $this->render('maitre_stage/index.html.twig', [
            'maitre_stages' => $maitreStageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="maitre_stage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $maitreStage = new MaitreStage();
        $form = $this->createForm(MaitreStageType::class, $maitreStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($maitreStage);
            $entityManager->flush();

            return $this->redirectToRoute('maitre_stage_index');
        }

        return $this->render('maitre_stage/new.html.twig', [
            'maitre_stage' => $maitreStage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maitre_stage_show", methods={"GET"})
     */
    public function show(MaitreStage $maitreStage): Response
    {
        return $this->render('maitre_stage/show.html.twig', [
            'maitre_stage' => $maitreStage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="maitre_stage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MaitreStage $maitreStage): Response
    {
        $form = $this->createForm(MaitreStageType::class, $maitreStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('maitre_stage_index');
        }

        return $this->render('maitre_stage/edit.html.twig', [
            'maitre_stage' => $maitreStage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maitre_stage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MaitreStage $maitreStage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maitreStage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($maitreStage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maitre_stage_index');
    }
}
