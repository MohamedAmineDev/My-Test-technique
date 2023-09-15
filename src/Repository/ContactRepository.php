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

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    //    /**
    //     * @return Contact[] Returns an array of Contact objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    /**
     * Elle retourne un contact  qui a l'id spécifié
     *
     * @param string $id
     * 
     * 
     * @return ?Contact
     *
     *
     */


    public function findById($id): ?Contact
    {
        return $this->createQueryBuilder('c1')
            ->andWhere('c1.id=:val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Elle retourne un array qui contient la page actuelle, nombre de pages et contacts paginés
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
        $query = $this->createQueryBuilder("c2")
            ->orderBy("c2.id", "ASC")
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
    //    public function findOneBySomeField($value): ?Contact
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
