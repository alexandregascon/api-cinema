<?php

namespace App\Repository;

use App\Entity\Film;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 *
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * @return Film[] Returns an array of Film objects
     */
        public function findFilmAffiche(): array
    {
        $date = new \DateTime();
        $date = $date->format("Y-m-d");
        return $this->createQueryBuilder("f")
            ->select("f")
            ->from("App:Seance","s")
            ->where("f.id = s.film")
            ->andWhere("s.dateProj >= :date")
            ->setParameter("date",$date)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDetailFilm(int $id): array
    {
        return $this->createQueryBuilder("f")
            ->select("f")
            ->from("App:Seance","s")
            ->where("f.id = s.film")
            ->andWhere("s.dateProj >= :date")
            ->where("f.id = :id")
            ->setParameter(":id",$id)
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?Film
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
