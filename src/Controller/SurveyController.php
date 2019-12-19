<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Survey;
use App\Entity\SurveyResponse;
use App\Form\SurveyResponseType;
use App\Form\SurveyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function addSurvey(Request $request){
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
            }
            $entityManager->flush();


            return $this->redirectToRoute("surveys_list");
        }
        
        return $this->render("survey/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/surveys/{id}", name="surveys_response", requirements={"id"="\d+"})
     */
    public function surveyResponse(Survey $survey){
        $form = $this->createForm(SurveyResponseType::class, new SurveyResponse());
        $form->remove('survey'); // going to set this after we submit the form
        $form->remove('question'); // looping through these...
        $form->remove('answer'); // looping through these...

        foreach ($survey->getSurveyTemplate()->getQuestions() as $question) {
            $form->add('answer', TextType::class, [
                'label' => $question->getQuestion(),
                'mapped' => false
            ]);
        }

        return $this->render("survey/form.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
