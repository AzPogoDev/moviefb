<?php

namespace App\Controller;

use App\Repository\MovieEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/movie", name="movie")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }
}
