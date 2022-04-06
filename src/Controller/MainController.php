<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Soin;
use App\Entity\Reservation;
use App\Entity\Users;
use App\Form\EditProfileType;
use App\Repository\CategorieRepository;
use App\Repository\SoinRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'categories' =>  $categorieRepository->findAll(),
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
     * @Route("/categorie/{id}", name="categorie_page")
     */
    public function PrestationsPage(Categorie $categorie, soinRepository $soinRepository): Response
    {
        return $this->render('pages/prestations.html.twig', [
            'categorie' => $categorie,
            'soins' => $soinRepository->findBy([
                'categorie' => $categorie
            ]),
        ]);
    }

    /**
     * @Route("/moncompte", name="moncompte")
     */
    public function moncompte(ReservationRepository $reservationRepository): Response

    {

        $user = $this->getUser();

        return $this->render('pages/moncompte.html.twig', [
            'reservations' => $reservationRepository->find($user),
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
     * @Route("/soin/{id}", name="soin_page")
     */
    public function soinPage(Categorie $categorie, Soin $soin): Response
    {
        return $this->render('pages/soin/soin.html.twig', [
            'categorie' => $categorie,
            'soin' => $soin
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
     * @Route("/categorie/{id}", name="prestation")
     */
    public function Prestations(): Response
    {
        return $this->render('pages/prestations.html.twig');
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
