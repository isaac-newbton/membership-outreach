<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('password', PasswordType::class, [
				'mapped'=>false
			])
			->add('new_password', RepeatedType::class, [
				'type'=>PasswordType::class,
				'invalid_message'=>'The new password must be entered twice.',
				'options'=>[
					'attr'=>['class'=>'password-field']
				],
				'required'=>true,
				'first_options'=>['label'=>'New Password'],
				'second_options'=>['label'=>'Repeat New Password'],
				'mapped'=>false
			])
			->add('save', SubmitType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults([
			'data_class'=>User::class
		]);
	}
}