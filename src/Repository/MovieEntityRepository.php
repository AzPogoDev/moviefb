<?php

namespace App\Repository;

use App\Entity\MovieEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @method MovieEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieEntity[]    findAll()
 * @method MovieEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieEntityRepository extends ServiceEntityRepository
{

    private HttpClientInterface $client;
    public function __construct(ManagerRegistry $registry, HttpClientInterface $client)
    {
        $this->client = $client;
        parent::__construct($registry, MovieEntity::class);

    }

    public function findMovie($id)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/'.$id.'?api_key=b24a9912967fe9831e0815a7d4e0f139'
        );
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        return $content;
    }

    public function getPopularMovies(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/popular?api_key=b24a9912967fe9831e0815a7d4e0f139&language=en-FR&page=1'
        );
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        return $content['results'];
    }

    public function findByKeywords($key)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie?api_key=b24a9912967fe9831e0815a7d4e0f139&language=en-US&query=' . $key . '&page=1&include_adult=false'
        );
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        return $content['results'];
    }

}
