<?php

namespace App\Controller;

use App\Entity\ProduitBoutique;
use App\Repository\ProduitBoutiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FicheproduitController extends AbstractController
{
    /**
     * @Route("/ficheproduit", name="app_ficheproduit")
     */
    public function index(ProduitBoutiqueRepository $produitBoutiqueRepository): Response
    {
        $produitBoutique = $produitBoutiqueRepository->findOneBy(['slug => $slug']);
            return $this->render('pages/ficheproduit.html.twig', compact('produitBoutique'));
        }
    }