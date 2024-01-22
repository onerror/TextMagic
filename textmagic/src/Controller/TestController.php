<?php

namespace App\Controller;

use App\Dto\TestAttemptAnswerDTO;
use App\Form\TestAttemptQuestionType;
use App\Repository\CustomerRepository;
use App\Repository\QuestionRepository;
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
        private readonly CustomerRepository $customerRepository, // todo later change for using a service or an interface
        private readonly QuestionRepository $questionRepository, // todo later change for using a service or an interface
    ) {
    }
    
    #[Route('/',
        name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {
        $testsAvailable = $this->testService->getAvailableTests();
        return $this->render('index.html.twig', [
            'tests' => $testsAvailable,
        ]);
    }
    
    #[Route('/test/{id}',
        name: 'app_test', requirements: ['id' => '\d+'], defaults: ['id' => null], methods: ['GET'])]
    public function handleTest(int $id = null): Response
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
            return $this->redirectToRoute(
                'app_test_attempt',
                [
                    'testId' => $test->getId(),
                    'testAttemptId' => $uncompletedTestAttempt->getId()
                ]
            );
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
        name: 'app_test_attempt', requirements: ['testId' => '\d+', 'testAttemptId' => '\d+'], methods: [
            'GET',
            'POST'
        ])]
    public function handleTestAttempt(int $testId, int $testAttemptId, Request $request): Response
    {
        $testAttempt = $this->testAttemptService->getById($testAttemptId);
        if (!$testAttempt) {
            throw $this->createNotFoundException('Простите, но вы попали на несуществующую страницу теста');
        }
        if ($testAttempt->isIsCompleted()) {
            return $this->render('test/results.html.twig', [
                'test' => $testAttempt->getTest(),
                'right_questions' => $this->testAttemptService->getQuestionsAnsweredRight($testAttempt),
                'wrong_questions' => $this->testAttemptService->getQuestionsAnsweredWrong($testAttempt),
            ]);
        }
        
        $nextQuestion = $this->testAttemptService->getRandomUnansweredQuestion($testAttempt);
        if ($nextQuestion) {
            $response = $this->redirectToRoute(
                'app_question',
                [
                    'testId' => $testId,
                    'testAttemptId' => $testAttempt->getId(),
                    'questionId' => $nextQuestion->getId(),
                ]
            );
            return $response;
        } else {
            $this->testAttemptService->markAttemptCompleted($testAttempt);
            $response = $this->redirectToRoute(
                'app_test_attempt',
                [
                    'testId' => $testId,
                    'testAttemptId' => $testAttempt->getId()
                ]
            );
            
            return $response;
        }
    }
    
    #[Route('/test/{testId}/{testAttemptId}/{questionId}',
        name: 'app_question', requirements: ['testId' => '\d+', 'testAttemptId' => '\d+', 'questionId' => '\d+'], methods: [
            'GET',
            'POST'
        ])]
    public function handleQuestion(int $testId, int $testAttemptId, int $questionId, Request $request): Response
    {
        $nextQuestion = $this->questionRepository->find($questionId);
        if (!$nextQuestion){
            throw new \InvalidArgumentException("Нет вопроса с идентификатором $questionId");
        }
        $testAttempt = $this->testAttemptService->getById($testAttemptId);
        if (!$testAttempt) {
            throw new \InvalidArgumentException("Не существует сессии теста с идентификатором $testAttemptId");
        }
        $dto = new TestAttemptAnswerDTO();
        $dto->setQuestionId($nextQuestion->getId());
        $dto->setTestAttemptId($testAttemptId);
        
        $answerOptions = $nextQuestion->getAnswerVariants()->toArray();
        shuffle($answerOptions); // randomize the order of answer options
        
        $form = $this->createForm(TestAttemptQuestionType::class, $dto, ['answer_variants' => $answerOptions]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->testAttemptService->addNewAnswer($form->getData());
            $response = $this->redirectToRoute(
                'app_test_attempt',
                [
                    'testId' => $testId,
                    'testAttemptId' => $testAttemptId
                ]
            );
            
            return $response;
        }
        
        return $this->render('test/question.html.twig', [
            'form' => $form->createView(),
            'test_title' => $testAttempt->getTest()->getTitle(),
            'question' => $nextQuestion
        ]);
    }
    
    
}