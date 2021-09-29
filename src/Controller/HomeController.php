<?php

namespace App\Controller;

use App\Repository\FavoriteMovieRepository;
use App\Repository\MovieEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class HomeController extends AbstractController
{


    /**
     * @var FavoriteMovieRepository
     */
    private FavoriteMovieRepository $favoriteMovieRepository;
    /**
     * @var MovieEntityRepository
     */
    private MovieEntityRepository $movieEntityRepository;

    public function __construct(FavoriteMovieRepository $favoriteMovieRepository, MovieEntityRepository $movieEntityRepository)
    {
        $this->favoriteMovieRepository = $favoriteMovieRepository;
        $this->movieEntityRepository = $movieEntityRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(MovieEntityRepository $movieEntityRepository, Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'movies' => $movieEntityRepository->getPopularMovies()
        ]);
    }

    /**
     * @Route("movie/add/{title}/", name="add_favorite")
     * @param $title
     * @param Request $request
     * @return Response
     */
    public function addToFavorite($title, Request $request): Response
    {
        $this->favoriteMovieRepository->addFavorite($title, $request->get('id'));

        return $this->render('home/index.html.twig', [
            'movies' => $this->movieEntityRepository->getPopularMovies()
        ]);
    }
}
