<?php

namespace App\Repository;

use App\Entity\FavoriteMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method FavoriteMovie|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteMovie|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteMovie[]    findAll()
 * @method FavoriteMovie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteMovieRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, Security $security)
    {
        parent::__construct($registry, FavoriteMovie::class);
        $this->manager = $manager;
        $this->security = $security;
    }

    public function addFavorite($movietitle, $movieid)
    {
        $favorite = $this->findFavoriteMovie($this->security->getUser()->getUserIdentifier(), $movietitle);
        if (!$favorite) {
            $favorite = new FavoriteMovie();
            $favorite
                ->setMovieTitle($movietitle)
                ->setMovieId($movieid)
                ->setUserEmail($this->security->getUser()->getUserIdentifier());
            $this->manager->persist($favorite);
        } else {
            $this->manager->remove($favorite);
        }
        $this->manager->flush();
    }

    public function findFavoriteMovie($user, $movie)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user_email = :useremail')
            ->andWhere('f.movie_title = :movietitle')
            ->setParameter('useremail', $user)
            ->setParameter('movietitle', $movie)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getFavoritesMovies($user)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user_email = :useremail')
            ->setParameter('useremail', $user)
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return FavoriteMovie[] Returns an array of FavoriteMovie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavoriteMovie
    {

    }
    */
}
