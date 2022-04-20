<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Users;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adresse")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/liste-adresse", name="app_adresse_index")
     */
    public function index(AdresseRepository $adresseRepository): Response
    {
        return $this->render('adresse/index.html.twig', [
            'adresses' => $adresseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouter-adresse", name="app_adresse_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, AdresseRepository $adresseRepository): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $this->getUser();
            $adresse ->setUser($users);
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash('adresse_message', "Votre adresse a bien été enregistré");
            return $this->redirectToRoute('moncompte', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adresse_show", methods={"GET"})
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('adresse/show.html.twig', [
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="app_adresse_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Adresse $adresse, AdresseRepository $adresseRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('adresse_message', 'Votre adresse a bien été modifié');
            return $this->redirectToRoute('moncompte', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="app_adresse_delete", methods={"POST"})
     */
    public function delete(Request $request, Adresse $adresse, AdresseRepository $adresseRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $adresseRepository->remove($adresse);
            $entityManager->flush();
            $this->addFlash('adresse_message', 'Votre adresse a bien été supprimé');
        }
        
        return $this->redirectToRoute('moncompte');
    }
}