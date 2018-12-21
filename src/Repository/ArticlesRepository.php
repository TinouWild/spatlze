<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    /**
    * @return Articles[] Returns an array of Articles objects
    */

    public function findByMostRecentDate(\DateTime $date)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.date <= :date')
            ->setParameter('date', $date)
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findLastSixRecentDate(\DateTime $date)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.date <= :date')
            ->setParameter('date', $date)
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserConnect($idUser)
    {
        $conn = $this->getEntityManager()->getConnection();
        $playslist =
            'SELECT * FROM articles A, user U, articles_user AU 
             WHERE A.id=AU.articles_id AND U.id=AU.user_id AND U.id = :idUser';
        $stmt = $conn->prepare($playslist);
        $stmt->execute(['idUser'=>$idUser]);
        return $stmt->fetchAll();
    }
    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
