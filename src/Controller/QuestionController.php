<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionController extends AbstractController {

    /**
     * @Route("/questions/list", name="questions_list")
     */
    public function showQuestions(){
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render("question/list.html.twig", [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/questions/create", name="questions_create")
     */
    public function createQuestion(Request $request){
        $form = $this->createForm(QuestionType::class, new Question());
        $form->add("save", SubmitType::class);
        $form->remove("surveyTemplates");

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();
        }

        return $this->render("question/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/questions/delete/{id}", name="questions_delete", requirements={"id"="\d+"})
     */
    public function deleteQuestion(int $id){
        
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Question::class)->find($id);

        if ($question) {
            // $entityManager->remove($question);
            // $entityManager->flush();
        } else {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        return $this->redirectToRoute('questions_list');
    }
}