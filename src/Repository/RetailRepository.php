<?php

namespace App\Repository;

use App\Entity\Retail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Retail>
 *
 * @method Retail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retail[]    findAll()
 * @method Retail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retail::class);
    }

    public function add(Retail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Retail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findDaysAgo(int $day = 7): array
    {
        $date1 = (new \DateTime())->sub(new \DateInterval('P'. $day .'D'));
        return $this->createQueryBuilder('r')
                    ->andWhere('r.date < :val')
                    ->setParameter('val', $date1)
                    ->orderBy('r.id', 'ASC')
                    ->getQuery()
                    ->getResult()
                ;
    }

    public function findByMyRefs($value): array
    {
        return $this->createQueryBuilder('r')
                    ->andWhere('r.consumer IN :val')
                    ->setParameter('val', $value)
                    ->orderBy('r.id', 'ASC')
                    // ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                ;
    }

//    /**
//     * @return Retail[] Returns an array of Retail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Retail
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
