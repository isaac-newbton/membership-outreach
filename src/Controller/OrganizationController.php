<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Survey;
use App\Form\OrganizationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationController extends AbstractController {

    /**
     * @Route("/organizations/list", name="organizations_list")
     */
    public function showOrganizations(){
        $organizations = $this->getDoctrine()->getRepository(Organization::class)->findAll();
        return $this->render("organization/list.html.twig", [
            'organizations' => $organizations
        ]);
    }

    /**
     * @Route("/organizations/add", name="organizations_add")
     */
    public function addOrganization(Request $request){
        $form = $this->createForm(OrganizationType::class, new Organization())
        ->add("submit", SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $organization = $form->getData();
            $entityManager->persist($organization);
            $entityManager->flush();
            return $this->redirectToRoute("organizations_list");
        }

        return $this->render("organization/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("organizations/{id}/surveys", name="organization_surveys", requirements={"id"="\d+"})
     */
    public function showOrganizationSurveys(Organization $organization){
        $organizationSurveys = $this->getDoctrine()->getRepository(Survey::class)->findBy([
            'organization' => $organization,
        ]);

        return $this->render("organization/surveys.html.twig", [
            "organization" => $organization,
            "surveys" => $organizationSurveys,
        ]);
    }
}