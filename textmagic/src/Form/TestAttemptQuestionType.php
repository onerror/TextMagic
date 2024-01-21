<?php

namespace App\Form;

use App\Dto\TestAttemptAnswerDTO;
use App\Entity\AnswerVariant;
use App\Entity\Question;
use App\Entity\TestAttempt;
use App\Entity\TestAttemptAnswer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestAttemptQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $answerVariants = $options['answer_variants'];

        
        $builder->add('userAnswerBitmask', ChoiceType::class, [
            'choices' => $answerVariants,
            'choice_value' => 'alias',
            'choice_label' => function (?AnswerVariant $answerVariant): string {
                return $answerVariant->getTitle();
            },
            'expanded' => true,
            'multiple' => true,
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ответить'
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => TestAttemptAnswerDTO::class,
                                   'answer_variants' => [],
                               ]);
    }
    
}