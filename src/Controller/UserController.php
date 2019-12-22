<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController{

	/**
	 * @Route("/account", name="account")
	 */
	public function account(Request $request, UserPasswordEncoderInterface $encoder){
		$form = $this->createForm(ChangePasswordType::class);

		$form->handleRequest($request);
		$form_data = $form->getData();
		if($form->isSubmitted() && $form->isValid()){
			// $user = $this->getUser();
			// if($encoder->isPasswordValid($user, $form_data['password'])){
			// 	if(6<=strlen($form_data['new_password'])){
			// 		$entityManager = $this->getDoctrine()->getManager();
			// 		$user->setPassword($encoder->encodePassword($user, $form_data['new_password']));
			// 		$entityManager->persist($user);
			// 		$entityManager->flush();
			// 	}else{
			// 		throw new \Exception('New password must be 6 characters or longer.');
			// 	}
			// }else{
			// 	throw new \Exception('Current password invalid.');
			// }
		}

		return $this->render("user/account.html.twig", ['form'=>$form->createView(), 'form_data'=>$form_data ?? false]);
	}
}