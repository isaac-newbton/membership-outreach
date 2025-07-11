<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\Survey;
use App\Entity\SurveyTemplate;
use App\Entity\Tag;
use App\Service\Survey\SurveyHandler;
use DateTimeZone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->surveyHandler = new SurveyHandler();
        $builder
            ->add('dueDate')
            ->add('surveyTemplate', EntityType::class, [
                'class' => SurveyTemplate::class,
                'choice_label' => function($st) {
                    return $st->getName();
                },
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function($t) {
                    return $t->getName();
                },
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => "Companies",
                'help' => "Surveys will be created for all Organizations matching the selected tags"
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Survey Status',
                'choices' => $this->surveyHandler->getSurveyStatusTypes(),
                'expanded' => true
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
