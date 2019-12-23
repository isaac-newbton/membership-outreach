<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController{

	/**
	 * @Route("/account", name="account")
	 */
	public function account(Request $request, UserPasswordEncoderInterface $encoder){

		$changePassword = new ChangePassword();
		$form = $this->createForm(ChangePasswordType::class, $changePassword);

		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$user = $this->getUser();
			$entityManager = $this->getDoctrine()->getManager();
			$user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));
			$entityManager->persist($user);
			$entityManager->flush();
		}

		return $this->render("user/account.html.twig", ['form'=>$form->createView()]);
	}
}