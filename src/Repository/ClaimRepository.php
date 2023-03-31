<?php

namespace App\Repository;

use App\Entity\Claim;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Claim>
 *
 * @method Claim|null find($id, $lockMode = null, $lockVersion = null)
 * @method Claim|null findOneBy(array $criteria, array $orderBy = null)
 * @method Claim[]    findAll()
 * @method Claim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Claim::class);
    }

    public function save(Claim $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Claim $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function findSalesmanStore($uid): array
    {
        return $this->createQueryBuilder('c')
                    ->leftJoin('c.store', 'store')
                    ->leftJoin('c.prize', 'prize')
                    ->andWhere('store.salesman = :uid')
                    ->andWhere('prize.label = :label')
                    ->andWhere('c.storeSettled = false')
                    ->setParameter('uid', $uid)
                    ->setParameter('label', 'onemore')
                    ->orderBy('c.id', 'DESC')
                    ->getQuery()
                    ->getResult()
                ;
    }
    
    public function findSalesmanServeStore($uid): array
    {
        return $this->createQueryBuilder('c')
                    ->leftJoin('c.serveStore', 'serveStore')
                    ->leftJoin('c.prize', 'prize')
                    ->andWhere('serveStore.salesman = :uid')
                    ->andWhere('prize.label = :label')
                    ->andWhere('c.serveStoreSettled = false')
                    ->setParameter('uid', $uid)
                    ->setParameter('label', 'onemore')
                    ->orderBy('c.id', 'DESC')
                    ->getQuery()
                    ->getResult()
                ;
    }

//    /**
//     * @return Claim[] Returns an array of Claim objects
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

//    public function findOneBySomeField($value): ?Claim
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
