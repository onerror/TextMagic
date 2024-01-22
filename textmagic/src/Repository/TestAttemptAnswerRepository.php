<?php

namespace App\Repository;

use App\Entity\TestAttemptAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestAttemptAnswer>
 *
 * @method TestAttemptAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestAttemptAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestAttemptAnswer[]    findAll()
 * @method TestAttemptAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestAttemptAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestAttemptAnswer::class);
    }
    
    public function save(TestAttemptAnswer $testAttemptAnswer): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($testAttemptAnswer);
        $entityManager->flush();
    }
}
