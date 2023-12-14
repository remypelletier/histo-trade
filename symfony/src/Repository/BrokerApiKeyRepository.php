<?php

namespace App\Repository;

use App\Entity\BrokerApiKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrokerApiKey>
 *
 * @method BrokerApiKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrokerApiKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrokerApiKey[]    findAll()
 * @method BrokerApiKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrokerApiKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrokerApiKey::class);
    }

//    /**
//     * @return BrokerApiKey[] Returns an array of BrokerApiKey objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BrokerApiKey
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
