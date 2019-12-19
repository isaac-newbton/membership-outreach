<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\Survey;
use App\Entity\SurveyTemplate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dueDate')
            ->add('surveyTemplate', EntityType::class, [
                'class' => SurveyTemplate::class,
                'choice_label' => function($st) {
                    return $st->getName();
                },
            ])
            ->add('organization', EntityType::class, [
                'class' => Organization::class,
                'choice_label' => function($o) {
                    return $o->getName();
                },
                'mapped' => false,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
