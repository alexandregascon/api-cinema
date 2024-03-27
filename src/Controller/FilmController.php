<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(FilmRepository $filmRepository, SerializerInterface $serializer): Response
    {
        // Rechercher tous les Films dans la base de données
        $films = $filmRepository->findFilmAffiche();

        // Serialiser le tableau de Films en Json
        $filmsJson = $serializer->serialize($films,"json",['groups'=>'affiche_films']);
        // Construire la réponse HTTP
        // VERSION CONDENCE
        return new Response($filmsJson,Response::HTTP_OK,["content-type"=>"application/json"]);
    }

    #[Route('/film/{id}', name: 'app_detail_film')]
    public function detail(FilmRepository $filmRepository, SerializerInterface $serializer, int $id): Response
    {
        // Rechercher tous les Films dans la base de données
        $films = $filmRepository->findDetailFilm($id);

        // Serialiser le tableau de Films en Json
        $filmsJson = $serializer->serialize($films,"json");
        // Construire la réponse HTTP
        // VERSION CONDENCE
        return new Response($filmsJson,Response::HTTP_OK,["content-type"=>"application/json"]);
    }
}
