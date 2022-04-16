<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\ProduitBoutique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\Security\Core\Security;
use DateTimeImmutable;

class ForumController extends AbstractController
{
    
    /**
     * @Route("/forum/{id}", name="forum")
     */
    public function indexForumDrapeau(produitBoutique $produitBoutique, CommentRepository $commmentRepository, Request $request): Response
    {
        //On créé le commentaire "vierge"
        $comment = new Comment;

        //On génère le formulaire
        $form = $this->createForm(CommentType::class, $comment);
        $user = $this->security->getUser();

        $form->handleRequest($request);

        //Traitement du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new DateTimeImmutable());

            $produitBoutique->addComment($comment);

            // On récupère le contenu du champ parentid
            $parentid = $form->get("parent")->getData();

            $em = $this->getDoctrine()->getManager();

            //On va chercher le commentaire correspondant
            if($parentid != null){
                $parent = $em->getRepository(Comment::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', '✔️ Votre commentaire a bien été envoyé ! ✔️');

            return $this->redirectToRoute('forum', ['id' => $produitBoutique->getId()]);
        }

        return $this->render('forum/forum.html.twig', [
            'produitBoutique' => $produitBoutique,
            'comment' => $commmentRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
