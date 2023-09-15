<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Repository
 * @copyright 2023 Quantic Factory
 */

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
