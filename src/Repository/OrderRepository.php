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

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    /**
     * Elle retourne un order qui a l'id spécifié
     *
     * @param string $id
     * 
     * 
     * @return ?Order
     *
     *
     */


    public function findById(string $id): ?Order
    {
        return $this->createQueryBuilder("o1")
            ->andWhere("o1.id=:val")
            ->setParameter("val", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Elle retourne un array qui contient la page actuelle, nombre de pages et orders paginés
     *
     * @param int $page
     * 
     * @param int $limit par défaut a 5 comme valeur
     *
     *  @return array
     *
     *
     */

    public function paginationQuery(int $page, int $limit = 5): array
    {
        $page = abs($page);
        $result = [];
        $query = $this->createQueryBuilder("o2")
            ->orderBy("o2.id", "ASC")
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
            ->getQuery();
        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
        if (empty($data)) {
            return $result;
        }
        $pages = ceil($paginator->count() / $limit);
        $result["data"] = $data;
        $result["pages"] = $pages;
        $result["page"] = $page;
        $result["limit"] = $limit;
        return $result;
    }
    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
