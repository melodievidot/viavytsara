<?php

namespace App\Controller;

use App\Entity\Soin;
use App\Form\Soin1Type;
use App\Repository\SoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/soin")
 */
class SoinController extends AbstractController
{
    /**
     * @Route("/", name="soin_index", methods={"GET"})
     */
    public function index(SoinRepository $soinRepository): Response
    {
        return $this->render('soin/index.html.twig', [
            'soins' => $soinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="soin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $soin = new Soin();
        $form = $this->createForm(Soin1Type::class, $soin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($soin);
            $entityManager->flush();

            return $this->redirectToRoute('soin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('soin/new.html.twig', [
            'soin' => $soin,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="soin_show", methods={"GET"})
     */
    public function show(Soin $soin): Response
    {
        return $this->render('soin/show.html.twig', [
            'soin' => $soin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="soin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Soin $soin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Soin1Type::class, $soin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('soin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('soin/edit.html.twig', [
            'soin' => $soin,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="soin_delete", methods={"POST"})
     */
    public function delete(Request $request, Soin $soin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$soin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($soin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('soin_index', [], Response::HTTP_SEE_OTHER);
    }
}
