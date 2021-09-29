<?php

namespace App\Controller;

use App\Repository\FavoriteMovieRepository;
use App\Repository\MovieEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Security\Core\Security;

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
    public function index(MovieEntityRepository $movieEntityRepository, Request $request, Security $security): Response
    {
        $moviesfav = $this->favoriteMovieRepository->getFavoritesMovies($security->getUser()->getUserIdentifier());

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'favmovies' => $moviesfav,
            'movies' => $movieEntityRepository->getPopularMovies()
        ]);
    }

    /**
     * @Route("movie/add/{title}/", name="add_favorite")
     * @param $title
     * @param Request $request
     * @return Response
     */
    public function addToFavorite($title, Request $request, Security $security): Response
    {
        $this->favoriteMovieRepository->addFavorite($title, $request->get('id'));

//        return $this->render('home/index.html.twig', [
//            'movies' => $this->movieEntityRepository->getPopularMovies(),
//            'favmovies' => $moviesfav,
//        ]);
//
        return $this->redirectToRoute('home');

    }
}
