<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Form\SurveyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                $entityManager->flush();
            }


            return $this->redirectToRoute("surveys_list");
        }
        
        return $this->render("survey/form.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
