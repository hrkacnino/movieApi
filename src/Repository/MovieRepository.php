<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function save(Movie $object){
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    public function getMoviesByUserId($userId){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT m, c FROM App:Movie m
            INNER JOIN cast_movie cm on m.id = cm.movie_id
            INNER JOIN cast c on cm.cast_id = c.id
            WHERE m.user_id = :userId'
            )->setParameter('userId', $userId);

        try {
            return $query->getArrayResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getMoviesByUserId2($userId){
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('movie', 'm')
            ->leftJoin('cast_movie', 'cm')
            ->leftJoin('cast', 'c')
            ->where("m.user_id= 20")
            ->getQuery()->getResult();
         /*       'SELECT m, c FROM App:Movie m
            INNER JOIN cast_movie cm on m.id = cm.movie_id
            INNER JOIN cast c on cm.cast_id = c.id
            WHERE m.user_id = :userId'
            )->setParameter('userId', $userId);*/

        try {
            return $query;
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getMoviesByUserId3($userId){
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('App:Movie', 'm');

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT m.*, c.* from movie m left join cast_movie cm on cm.movie_id = m.id left join cast c on c.id= cm.cast_id where m.user_id=20', $rsm);


        /*       'SELECT m, c FROM App:Movie m
           INNER JOIN cast_movie cm on m.id = cm.movie_id
           INNER JOIN cast c on cm.cast_id = c.id
           WHERE m.user_id = :userId'
           )->setParameter('userId', $userId);*/

        try {

            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getMoviesByUserId4($userId){
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare('SELECT m.*, c.*, r.* 
                            from movie m 
                                left join cast_movie cm on cm.movie_id = m.id 
                                left join cast c on c.id= cm.cast_id 
                                left join rating r on r.id = m.id
                            where m.user_id=?');
        $stmt->bindParam(1, $userId);
        $result = $stmt->executeQuery()->fetchAllAssociative();
        return $result;
    }

}
