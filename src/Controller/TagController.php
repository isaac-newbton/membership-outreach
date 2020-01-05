<?php
namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController {

	/**
	 * @Route("/tags/list", name="tags_list")
	 */
	public function tagsList(){

		return $this->render("tags/list.html.twig", [
			"tags" => $this->getDoctrine()->getRepository(Tag::class)->findAll()
		]);
	
	}

	/**
	 * @Route("tags/add", name="tags_add")
	 */
	public function createTag(HttpFoundationRequest $request){
		$form = $this->createForm(TagType::class);
		$form->add('save', SubmitType::class);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$tag = $form->getData();
			$entityManager->persist($tag);
			$entityManager->flush();

			return $this->redirectToRoute("tags_list");

		}

		return $this->render("tags/form.html.twig", [
			"form" => $form->createView()
		]);
	}
}