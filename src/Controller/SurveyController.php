<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Entity\SurveyResponse;
use App\Entity\SurveyTemplate;
use App\Form\SurveyResponseType;
use App\Form\SurveyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Survey\SurveyHandler;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\Session;

class SurveyController extends AbstractController
{
    /**
     * @Route("/surveys/list", name="surveys_list")
     */
    public function showSurveys(){
        $surveys = $this->getDoctrine()->getRepository(Survey::class)->findBy([
            'status' => [1, null],
        ]);

        return $this->render("survey/list.html.twig", [
            "surveys" => $surveys
        ]);
    }

    /**
     * @Route("/surveys/delete/{id}", name="surveys_delete", requirements={"id"="\d+"})
     */
    public function deleteSurvey(Survey $survey, Session $session){
        if ($survey){
            $entityManager = $this->getDoctrine()->getManager();
            $session->getFlashBag()->add('message', "Survey deleted ({$survey->getSurveyTemplate()->getName()} - {$survey->getOrganization()->getName()})");
            $entityManager->remove($survey);
            $entityManager->flush();
        }
        return $this->redirectToRoute("surveys_list");
    }

    /**
     * @Route("/surveys/list/closed", name="surveys_closed_list")
     */
    public function showClosedSurveys(){
        $surveys = $this->getDoctrine()->getRepository(Survey::class)->findBy([
            'status' => 2
        ]);

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
        $form->remove('status');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $organizations = [];
            $entityManager = $this->getDoctrine()->getManager();

            $survey = $form->getData();
            $survey->setStatus(1);

            foreach ($form->get('tags')->getData() as $t){
                // get all organizations from matching tags - make sure there are no dupes
                foreach($t->getOrganizations() as $o){
                    if (!in_array($o, $organizations, true)) $organizations[] = $o;
                }
            }

            foreach ($organizations as $o){
                $s = clone $survey;

                    $s->setOrganization($o);
                    $entityManager->persist($s);
                    $entityManager->flush();
                    $survey_handler->generateResponses($s, $entityManager);
                // }

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
        $form->add('survey', SurveyType::class, [
            'data' => $survey,
        ]);

        $surveyTemplate = $survey->getSurveyTemplate(); // FIXME: this isn't availaable after $form->handleRequest() ... don't know why !!

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $survey->setSurveyTemplate($surveyTemplate); // FIXME: need to manually set this value or we get a big red error

            $entityManager = $this->getDoctrine()->getManager();
            $surveyTemplate_responseIds = [];
            foreach ($survey->getSurveyResponses() as $response){
                $surveyTemplate_responseIds[] = $response->getId();
                if(isset($_POST[$response->getId()])){
                    $response->setAnswer($_POST[$response->getId()]);
                    $entityManager->persist($response);
                }
            }
            // $entityManager->persist($survey);
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
