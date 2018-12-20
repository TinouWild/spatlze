<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */

    public function findByMostRecentWriter($articleId)
    {
        return $this->createQueryBuilder('u')
            ->join('u.articles','a')
            ->addSelect('a')
            ->andwhere('u.id= :articleId')->setParameter('articleId', $articleId)
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findLastSixRecentWriter()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
