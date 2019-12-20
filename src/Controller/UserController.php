<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController{

	/**
	 * @Route("/account", name="account")
	 */
	public function account(Request $request){
		$form = $this->createForm(ChangePasswordType::class, $this->getUser());

		$form->handleRequest($request);
		$form_data = $form->getData();
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
		}

		return $this->render("user/account.html.twig", ['form'=>$form, 'form_data'=>$form_data ?? false]);
	}
}