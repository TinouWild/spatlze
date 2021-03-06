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
            ->andWhere('u.userRole = 11')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findAllWriter()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'ASC')
            ->andWhere('u.userRole = 11')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserConnect($idUser)
    {
        $conn = $this->getEntityManager()->getConnection();
        $playslist =
            'SELECT U.pseudo, U.avatar, U.slug FROM user U, user_user UU 
             WHERE U.id=UU.user_source AND U.id=UU.user_target AND UU.user_source = :idUser';
        $stmt = $conn->prepare($playslist);
        $stmt->execute(['idUser'=>$idUser]);
        return $stmt->fetchAll();
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
