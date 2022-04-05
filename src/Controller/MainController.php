<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Reservation;
use App\Entity\Users;
use App\Form\EditProfileType;
use App\Repository\CategorieRepository;
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
    public function CategoriePage(Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        return $this->render('pages/categorie/categorie.html.twig', [
            'categorie' => $categorie,
            'categorie' => $categorieRepository->findBy([
                'titre' => $categorie
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
     * @Route("/CGU", name="CGU")
     */
    public function mentionscgu(): Response
    {
        return $this->render('pages/cgu.html.twig');
    }

    /**
     * @Route("/politiquedeconfidentialite", name="conf")
     */
    public function conf(): Response
    {
        return $this->render('pages/conf.html.twig');
    }
}
