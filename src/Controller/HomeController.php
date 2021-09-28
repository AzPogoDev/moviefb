<?php

namespace App\Controller;

use App\Repository\MovieEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index( MovieEntityRepository $movieEntityRepository, Request $request): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'movies' => $movieEntityRepository->getPopularMovies()
        ]);
    }
}
