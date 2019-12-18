<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\SurveyTemplate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('questions', EntityType::class, ['class'=>Question::class, 'choice_label' => function($q){return $q->getQuestion();}])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SurveyTemplate::class,
        ]);
    }
}
