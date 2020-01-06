<?php
namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
	public function createTag(Request $request){
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

	/**
	 * @Route("tags/edit/{id}", name="tags_edit", requirements={"id":"\d+"})
	 */
	public function editTag(Request $request, Tag $tag){
		if ($tag){
			$form = $this->createForm(TagType::class, $tag);
			$form->add('Update', SubmitType::class);
			
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

	/**
	 * @Route("tags/delete/{id}", name="tags_delete", requirements={"id":"\d+"})
	 */
	public function deleteTag(Tag $tag, Session $session){
		if ($tag){
				$session->getFlashBag()->add('message', "Deleted tag: {$tag->getName()}");
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->remove($tag);
				$entityManager->flush();
				return $this->redirectToRoute("tags_list");
		}
	}
}