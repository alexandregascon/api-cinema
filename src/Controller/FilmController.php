<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(FilmRepository $filmRepository, SerializerInterface $serializer): Response
    {
        // Rechercher tous les Posts dans la base de données
        $films = $filmRepository->findBy();

        // Serialiser le tableau de Posts en Json
        $postsJson = $serializer->serialize($films,"json");
        // Construire la réponse HTTP
//        $reponse = new Response();
//        $reponse->setStatusCode(Response::HTTP_OK);
//        $reponse->headers->set("content-type","application/json");
//        $reponse->setContent($postsJson);
//        return $reponse;
        // VERSION CONDENCE
        return new Response($postsJson,Response::HTTP_OK,["content-type"=>"application/json"]);
    }
}
