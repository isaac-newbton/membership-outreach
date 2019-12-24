<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Survey;
use App\Entity\SurveyResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer')
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => function($q) {
                    return $q->getQuestion();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SurveyResponse::class,
        ]);
    }
}
