<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classes\Panier;
use App\Entity\Commande;
use App\Repository\ProduitBoutiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    
    public function checkout($stripeSK, Panier $panier): Response
    {
        Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'shipping_address_collection' => [
              'allowed_countries' => ['FR'],
            ],
            'shipping_options' => [
              [
                'shipping_rate_data' => [
                  'type' => 'fixed_amount',
                  'fixed_amount' => [
                    'amount' => 0,
                    'currency' => 'eur',
                  ],
                  'display_name' => 'Free shipping',
                  // Delivers between 5-7 business days
                  'delivery_estimate' => [
                    'minimum' => [
                      'unit' => 'business_day',
                      'value' => 5,
                    ],
                    'maximum' => [
                      'unit' => 'business_day',
                      'value' => 7,
                    ],
                  ]
                ]
              ],
              [
                'shipping_rate_data' => [
                  'type' => 'fixed_amount',
                  'fixed_amount' => [
                    'amount' => 500,
                    'currency' => 'eur',
                  ],
                  'display_name' => 'Next day air',
                  // Delivers in exactly 1 business day
                  'delivery_estimate' => [
                    'minimum' => [
                      'unit' => 'business_day',
                      'value' => 1,
                    ],
                    'maximum' => [
                      'unit' => 'business_day',
                      'value' => 1,
                    ],
                  ]
                ]
              ],
            ],

            'line_items' => [[
              'price_data' => [
                  'currency' => 'eur',
                  'product_data' => [
                      'name' => 'Ma commande',
                  ],
              'unit_amount' => $panier->getTotalePanier() * 100,
              ],
              'quantity' => $panier->getNombreArticlePanier(),
          ]],
          'mode' => 'payment',
          'success_url' => $this->generateUrl('sucess_url', [], UrlGeneratorInterface::ABSOLUTE_URL),

          'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
      ]);

      return $this->redirect($session->url, 303);
  }



    /**
     * @Route("/sucess_url", name="sucess_url")
     */
    public function sucessUrl(Panier $panierService, ProduitBoutiqueRepository $produitBoutiqueRepository, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $commande->setUser($this->getUser());
        $commande->setReference(strval(random_int(0, 999999)));
        $panier = $panierService->getPanier();
        foreach ($panier as $productId => $quantity) {
            $produit = $produitBoutiqueRepository->find($productId);
            $commande->addProduitBoutique($produit);
        }
        $commande->setPrix($panierService->getTotalePanier());
        $commande->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($commande);
        $entityManager->flush();
        
        return $this->render('payment/sucess.html.twig', []);
    }

    /**
     * @Route("/cancel_url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}
