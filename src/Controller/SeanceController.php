<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\SalleRepository;
use App\Repository\SeanceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SeanceController extends AbstractController
{
    #[Route('/reserver/{id}', name: 'app_reserver', requirements: ['id' => '\d+',"user_id"=>"\d+"], methods: ['POST'])]
    public function reserver(SeanceRepository $seanceRepository, \Symfony\Component\HttpFoundation\Request $request, SerializerInterface $serializer, UserRepository $userRepository, SalleRepository $salleRepository, int $id, int $user_id, EntityManagerInterface $entityManager): Response
    {
        $reservation = $request->getContent();
        $newReservation = new Reservation();
        $reservation = $serializer->deserialize($reservation, Reservation::class, 'json');
        $seance = $seanceRepository->find($id);
        $user = $userRepository->find($user_id);
        $salle = $seance->getSalle();
        if (empty($seance)) {
            $reservationJson = json_encode(['Code' => "404", "Erreur" => "Ce film n'existe pas"]);
            return new Response($reservationJson, Response::HTTP_NOT_FOUND);
        }
        if ($seance->getDateProj() < new \DateTime()) {
            $reservationJson = json_encode(['Code' => '404', 'Erreur' => "Cette séance n'éxiste plus"]);
            return new Response($reservationJson, Response::HTTP_NOT_FOUND);
        }
//        if ($salle->getNbPlaces() < $reservation->getNbPlaces()) {
//            $reservationJson = json_encode(['Code' => '400', 'Erreur' => "Cette séance n'a plus assez de place"]);
//            return new Response($reservationJson, Response::HTTP_BAD_REQUEST);
//        }
        $montant = $seance->getTarifNormal();
        $nbPlaces = $reservation->getNbPlaces();
        $dateReservation = new \DateTime();
        $newReservation->setDateReserv($dateReservation);
        $newReservation->setMontant($montant);
        $newReservation->setNbPlaces($nbPlaces);
        $newReservation->setSeance($seance);
        $newReservation->setUser($user);
//        $reservation->setNbPlaces($salle->getNbPlaces() - $nbPlaces);
        $entityManager->persist($newReservation);
//        $entityManager->persist($seance);
        $entityManager->flush();
        $reservationJson = json_encode(["Code" => '200', "Message" => "La réservation a bien été effectuée pour le film " . $seance->getFilm()->getTitre() . "."]);
        return new Response($reservationJson, Response::HTTP_OK);

    }
}
