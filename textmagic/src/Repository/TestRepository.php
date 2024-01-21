<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Test>
 *
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

//    /**
//     * @return Test[] Returns an array of Test objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneWithUnfulfilledAttemptsOrNoAttempts(Customer $customer): ?Test
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.testAttempts', 'ta', 'WITH', 'ta.customer = :customer')
            ->andWhere('ta.isCompleted = false OR ta IS NULL')
            ->setParameter('customer', $customer)
            ->setMaxResults(1)
            ->getQuery();
            $test = $query->getOneOrNullResult();

        
        return $test;
    }
}
