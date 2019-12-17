<?php

namespace App\Form;

use App\Entity\Question;
use App\Service\Question\QuestionHandler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType {
    private $questionHandler;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->questionHandler = new questionHandler();
        $builder
            ->add('question')
            ->add('type', ChoiceType::class, [
                'choices' => $this->questionHandler->getQuestionTypes()
            ])
            ->add('options', TextareaType::class, [
                'label' => 'Optional - select type options',
                'attr' => [
                    'placeholder' => 'option 1, option 2, option 3, etc',
                ],
            ])
            ->add('surveyTemplates')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
