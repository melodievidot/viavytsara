<?php

namespace App\Controller;
use App\Entity\Comment;
use App\Entity\ProduitBoutique;
use App\Form\EditProfileType;
use App\Repository\ProduitBoutiqueRepository;
use App\Repository\CommandeRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MainController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(ProduitBoutiqueRepository $produitBoutiqueRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'produit_boutiques' => $produitBoutiqueRepository->findAll(),
        ]);
    }


    /**
     * @Route("/boutique", name="boutique")
     */
    public function boutique(ProduitboutiqueRepository $ProduitboutiqueRepository): Response
    {
        return $this->render('pages/ficheproduit.html.twig', [
            'produit_boutiques' => $ProduitboutiqueRepository->findAll(),
        ]);
    }


    /**
     * @Route("/info", name="aproposdenous")
     */
    public function aproposdenous(): Response
    {
        return $this->render('pages/aproposdenous.html.twig');
    }

    /**
     * @Route("/moncompte", name="moncompte")
     */
    public function moncompte(CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser();

        return $this->render('pages/moncompte.html.twig', [
            'commande' => $commandeRepository->find($user),
        ]);
    }


  /**
      * @Route("/produit/{id}", name="produit_page")
      */
      public function ProduitProduitPage(ProduitBoutiqueRepository $ProduitboutiqueRepository): Response
      {
          return $this->render('pages/ficheproduit.html.twig', [
            'produit_boutiques' => $ProduitboutiqueRepository->findAll(),
        ]);
    }
          

    /**
     * @Route("/moncompte/modifier", name="modifiermoncompte")
     */
    public function modifiermoncompte(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException('Impossible d’accéder à cette page !');
        }
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', '✔️ Informations personnelles mises à jour ✔️');
            return $this->redirectToRoute('moncompte');
        }

        return $this->render('pages/modifiermoncompte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/CGU", name="CGU")
     */
    public function mentionscgu(): Response
    {
        return $this->render('pages/cgu.html.twig');
    }

    /**
     * @Route("/moncompte/modifier/motdepasse", name="modifiermotdepasse")
     */
    public function modifiermotdepasse(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if ($request->request->get('editpassword') == $request->request->get('editpassword2')) {
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('editpassword')));
                $em->flush();
                $this->addFlash('message', '✔️ Mot de passe mis à jour ✔️');

                return $this->redirectToRoute('moncompte');
            } else {
                $this->addFlash('error', '❌ Les deux mots de passe ne sont pas identiques ❌');
            }
        }

        return $this->render('pages/modifiermotdepasse.html.twig');
    }

    /**
         * @Route("/politiquedeconfidentialite", name="conf")
         */
    public function conf(): Response
    {
        return $this->render('pages/conf.html.twig');
    }
}