<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\TestAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }
    
    
    public function getRandomUnanwseredQuestion(TestAttempt $testAttempt):?Question
    {
        $query =  $this->createQueryBuilder('q')
        ->leftJoin('q.testAttemptAnswers', 'ta', 'WITH', 'ta.testAttempt = :testAttempt')
            ->andWhere('ta IS NULL')
            ->setParameter('testAttempt', $testAttempt)
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery();
        $result = $query->getOneOrNullResult();
        return $result;
    }
    
}
