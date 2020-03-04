<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('directoryUrl', TextType::class, [
                'label' => 'Website',
                'required' => false
            ])
            ->add('contactPerson', TextType::class, [
                'required'=>false
            ])
            ->add('contactPhoneNumber', TextType::class, [
                'label'=>'Business Phone Number',
                'required'=>false
            ])
            ->add('contactEmail', EmailType::class, [
                'label'=>'Business Email',
                'required'=>false
            ])
            ->add('contactFax', TextType::class, [
                'label'=>'Business Fax',
                'required'=>false
            ])
            ->add('contactOtherNumber', TextType::class, [
                'label'=>'Business Other Number',
                'required'=>false
            ])
            ->add('streetAddress1', TextType::class, [
                'label' => 'Street address (line 1)',
                'required'=>false
            ])
            ->add('streetAddress2', TextType::class, [
                'label' => 'Street address (line 2)',
                'required'=>false
            ])
            ->add('city', TextType::class, [
                'required'=>false
            ])
            ->add('state')
            ->add('postalCode', TextType::class, [
                'required'=>false
            ])
            ->add('country', TextType::class, [
                'required'=>false
            ])
            ->add('membershipCategory', TextType::class, [
                'required'=>false
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function ($t) {
                    return $t->getName();
                },
                'multiple' => true,
                'expanded' => true,
                'allow_extra_fields' => true,
                'help' => "Adding/removing tags will not affect previously generated surveys",
                'query_builder'=>function(TagRepository $repository){
                    return $repository->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
                    ;
                }
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
