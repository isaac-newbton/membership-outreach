<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Entity\SurveyResponse;
use App\Form\SurveyResponseType;
use App\Form\SurveyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Survey\SurveyHandler;

class SurveyController extends AbstractController
{
    /**
     * @Route("/surveys/list", name="surveys_list")
     */
    public function showSurveys(){
        $surveys = $this->getDoctrine()->getRepository(Survey::class)->findAll();

        return $this->render("survey/list.html.twig", [
            "surveys" => $surveys
        ]);
    }

    /**
     * @Route("/surveys/add", name="surveys_add")
     */
    public function addSurvey(Request $request, SurveyHandler $survey_handler){
        $form = $this->createForm(SurveyType::class, new Survey());
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();

            $survey = $form->getData();
            foreach ($form->get('organization')->getData() as $o){
                $s = clone $survey;
                $s->setOrganization($o);
                $entityManager->persist($s);
                $entityManager->flush();
                $survey_handler->generateResponses($s, $entityManager);
            }
            return $this->redirectToRoute("surveys_list");
        }
        
        return $this->render("survey/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("surveys/{id}", name="surveys_response", requirements={"id"="\d+"})
     */
    public function surveyResponse(Request $request, Survey $survey){

        $form = $this->createForm(SurveyResponseType::class, new SurveyResponse());
        $form->add('survey', SurveyType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();

            $surveyTemplate_responseIds = [];
            foreach ($survey->getSurveyResponses() as $response){
                $surveyTemplate_responseIds[] = $response->getId();
                if(isset($_POST[$response->getId()])){
                    $response->setAnswer($_POST[$response->getId()]);
                    $entityManager->persist($response);
                }
            }
            $survey->setStatus($form->get('survey')->get('status')->getData());
            $entityManager->persist($survey);
            $entityManager->flush();
            return $this->redirectToRoute('surveys_list');
        }

        return $this->render("survey/response_form.html.twig", [
            "form" => $form->createView(),
            "survey" => $survey,
            "questions" => $survey->getSurveyTemplate()->getQuestions(),
            "responses" => $survey->getSurveyResponses()
        ]);
    }
}
