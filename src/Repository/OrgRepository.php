<?php

namespace App\Repository;

use App\Entity\Org;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Org>
 *
 * @method Org|null find($id, $lockMode = null, $lockVersion = null)
 * @method Org|null findOneBy(array $criteria, array $orderBy = null)
 * @method Org[]    findAll()
 * @method Org[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Org::class);
    }

    public function add(Org $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Org $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByType($type): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.type = :type')
            ->setParameter('type', $type)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // Mainly for consumers type
    public function findOneByType($value): ?Org
    {
        return $this->createQueryBuilder('o')
                    ->andWhere('o.type = :type')
                    ->setParameter('type', $value)
                    ->getQuery()
                    ->getOneOrNullResult()
                ;
    }

    public function findOneById($value): ?Org
    {
        return $this->createQueryBuilder('o')
                    ->andWhere('o.id = :id')
                    ->setParameter('id', $value)
                    ->getQuery()
                    ->getOneOrNullResult()
                ;
    }

//    /**
//     * @return Org[] Returns an array of Org objects
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

//    public function findOneBySomeField($value): ?Org
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
