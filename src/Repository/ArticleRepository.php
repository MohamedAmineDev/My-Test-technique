<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function findById(string $id):?Article
    {
        return $this->createQueryBuilder("a1")
        ->andWhere("a1.id=:val")
        ->setParameter("val",$id)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function paginationQuery(int $page, int $limit = 5): array
    {
        $page=abs($page);
        $result = [];
        $query = $this->createQueryBuilder("a2")
            ->orderBy("a2.id", "ASC")
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
//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
