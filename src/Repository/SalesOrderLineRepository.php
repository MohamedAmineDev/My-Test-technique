<?php

namespace App\Repository;

use App\Entity\SalesOrderLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalesOrderLine>
 *
 * @method SalesOrderLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOrderLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOrderLine[]    findAll()
 * @method SalesOrderLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesOrderLine::class);
    }

    //    /**
    //     * @return SalesOrderLine[] Returns an array of SalesOrderLine objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    public function findByTheOrder(string $orderId): array
    {
        return $this->createQueryBuilder("s1")
            ->andWhere("s1.theOrder.id= :val")
            ->setParameter("val", $orderId)
            ->getQuery()
            ->getResult();
    }
    //    public function findOneBySomeField($value): ?SalesOrderLine
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
