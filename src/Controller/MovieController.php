<?php

namespace App\Controller;

use App\Repository\FavoriteMovieRepository;
use App\Repository\MovieEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="movie_post")
     * @param $id
     * @param MovieEntityRepository $repo
     * @return Response
     */
    public function show($id, MovieEntityRepository $repo): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => $repo->findMovie($id),
        ]);
    }


    /**
     * @Route("/favorites", name="favorites")
     * @param FavoriteMovieRepository $favoriteMovieRepository
     * @param Security $security
     * @return Response
     */
    public function favorites(FavoriteMovieRepository $favoriteMovieRepository, Security $security): Response
    {
        if ($security->getUser()) {
            $userconencted = $security->getUser()->getUserIdentifier();
        }
        $moviesfav = $favoriteMovieRepository->getFavoritesMovies($security->getUser()->getUserIdentifier());

        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'MovieController',
            'favmovies' => $moviesfav,
            'couser' => $userconencted ?? ''
        ]);
    }

    /**
     * @Route("/movie", name="movie")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }
}
