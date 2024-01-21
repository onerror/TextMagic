<?php

namespace App\Controller;

use App\Dto\TestAttemptAnswerDTO;
use App\Form\TestAttemptQuestionType;
use App\Repository\CustomerRepository;
use App\Service\TestAttemptService;
use App\Service\TestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    // while so far we don't have customers, logins etc implemented, let's stick to one customer with id=1
    public const int THE_ONLY_CUSTOMER_ID = 1;
    
    public function __construct(
        private readonly TestService $testService,
        private readonly TestAttemptService $testAttemptService,
        private readonly CustomerRepository $customerRepository
    ) {
    }
    
    #[Route('/test/{id}',
        name: 'app_test', requirements: ['id' => '\d+'], defaults: ['id' => null], methods: ['GET'])]
    public function index(int $id = null): Response
    {
        $customer = $this->customerRepository->find(self::THE_ONLY_CUSTOMER_ID);
        if ($id === null) {
            $test = $this->testService->getAnyUnfinishedTest($customer);
            if (!$test) {
                return $this->render('test/notest.html.twig');
            }
            return $this->redirectToRoute('app_test', ['id' => $test->getId()]);
        } else {
            $test = $this->testService->getTestById($id);
            if (!$test) {
                throw $this->createNotFoundException('Простите, но такого теста не существует');
            }
        }
        
        $uncompletedTestAttempt = $this->testAttemptService->getLastUncompletedTestAttempt($test);
        if ($uncompletedTestAttempt) {
            return $this->redirectToRoute('app_test_attempt', ['testId' => $test->getId(), 'testAttemptId' => $uncompletedTestAttempt->getId()]);
        } else {
            
            //if no attempts in database so far, create a new attempt
            $testAttempt = $this->testAttemptService->createNewAttempt($customer, $test);
            return $this->redirectToRoute(
                'app_test_attempt',
                [
                    'testId' => $test->getId(),
                    'testAttemptId' => $testAttempt->getId()
                ]
            );
        }
    }
    
    #[Route('/test/{testId}/{testAttemptId}',
        name: 'app_test_attempt', requirements: ['testId' => '\d+', 'testAttemptId' => '\d+'], methods: ['GET', 'POST'])]
    public function handleTestAttempt(int $testId, int $testAttemptId, Request $request): Response{
        $testAttempt = $this->testAttemptService->getById($testAttemptId);
        if (!$testAttempt){
            throw $this->createNotFoundException('Простите, но вы попали на несуществующую страницу теста');
        }
        if ($testAttempt->isIsCompleted()){

                return $this->render('test/results.html.twig', [
                    'test_title' => $testAttempt->getTest()->getTitle(),
                    'right_questions' => $this->testAttemptService->getQuestionsAnsweredRight($testAttempt),
                    'wrong_questions' => $this->testAttemptService->getQuestionsAnsweredWrong($testAttempt),
                ]);
        }
        
        $nextQuestion = $this->testAttemptService->getRandomUnansweredQuestion($testAttempt);
        if ($nextQuestion) {
            $dto = new TestAttemptAnswerDTO();
            $dto->setQuestionId($nextQuestion->getId());
            $dto->setTestAttemptId($testAttemptId);
            $form = $this->createForm(TestAttemptQuestionType::class, $dto, ['answer_variants' => $nextQuestion->getAnswerVariants()]);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $this->testAttemptService->addNewAnswer($form->getData());
                return $this->redirectToRoute(
                    'app_test_attempt',
                    [
                        'testId' => $testId,
                        'testAttemptId' => $testAttempt->getId()
                    ]
                );
            }
            
            return $this->render('test/question.html.twig', [
                'form' => $form->createView(),
                'test_title' => $testAttempt->getTest()->getTitle(),
                'question' => $nextQuestion
            ]);
            
        } else {
            $this->testAttemptService->markAttemptCompleted($testAttempt);
            return $this->redirectToRoute(
                'app_test_attempt',
                [
                    'testId' => $testId,
                    'testAttemptId' => $testAttempt->getId()
                ]
            );
        }
        

    }
}