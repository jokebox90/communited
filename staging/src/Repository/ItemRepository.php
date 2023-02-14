<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findAllByPage(int $offset = 0, int $limit = 10)
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int          getCount()
 * @method void         save(Item $entity, bool $flush = false)
 * @method void         remove(Item $entity, bool $flush = false)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function save(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.uniqueId)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllByPage(int $offset = 0, int $limit = 10): mixed
    {
        $count = $this->getCount();
        $firstResult = $count - $limit * ($offset + 1);
        $offset = $firstResult > 0 ? $firstResult : $count - $limit;
        return $this->createQueryBuilder('a')
            ->select('a')
            ->orderBy("a.uniqueId", "ASC")
            ->groupBy("a.uniqueId")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Item[] Returns an array of Item objects
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

    //    public function findOneBySomeField($value): ?Item
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
