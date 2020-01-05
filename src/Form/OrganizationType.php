<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('custom_id', TextType::class, [
                'required' => false
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function ($t) {
                    return $t->getName();
                },
                'multiple' => true,
                'expanded' => true,
                'allow_extra_fields' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class,
        ]);
    }
}
