<?php
namespace App\Controller;

use App\Entity\SurveyTemplate;
use App\Form\SurveyTemplateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SurveyTemplateController extends AbstractController{
	/**
	 * @Route("/surveys/templates", name="survey_templates_list")
	 */
	public function list(){
		$repository = $this->getDoctrine()->getRepository(SurveyTemplate::class);
		$templates = $repository->findAll();
		return $this->render('survey/template_list.html.twig', ['templates'=>$templates]);
	}

	/**
	 * @Route("/surveys/templates/delete/{id}", name="survey_templates_delete", requirements={"id":"\d+"})
	 */
	public function deleteSurveyTemplate(SurveyTemplate $surveyTemplate, Session $session){
		if ($surveyTemplate){
			$entityManager = $this->getDoctrine()->getManager();
			$session->getFlashBag()->add("message", "Deleted Survey Template '{$surveyTemplate->getName()}'");
			$entityManager->remove($surveyTemplate);
			$entityManager->flush();
		}
		return $this->redirectToRoute("survey_templates_list");
	}

	/**
	 * @Route("/surveys/templates/create", name="survey_templates_create")
	 */
	public function create(Request $request){
		$form = $this->createForm(SurveyTemplateType::class, new SurveyTemplate());
		$form->add("Save", SubmitType::class);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$template = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($template);
			$entityManager->flush();

			return $this->redirectToRoute("survey_templates_list");
		}

		return $this->render("survey/template_form.html.twig", [
			"form" => $form->createView()
		]);
	}
}