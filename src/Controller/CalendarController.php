<?php

namespace App\Controller;


use App\Repository\CalendrierRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class CalendarController extends AbstractController

{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(CalendrierRepository $calendrier)
    {
        $events = $calendrier->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'commentaire' => $event->getCommentaire(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('calendar/index.html.twig', compact('data'));
    }

}
