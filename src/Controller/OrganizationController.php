<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Survey;
use App\Form\OrganizationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
            $tags = $form->get('tags')->getData();
            foreach ($tags as $tag){
                $entityManager->persist($tag);
            }
            $entityManager->persist($organization);
            $entityManager->flush();
            return $this->redirectToRoute("organizations_list");
        }

        return $this->render("organization/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/organizations/edit/{id}", name="organizations_edit", requirements={"id":"\d+"})
     */
    public function editOrganization(Organization $organization, Request $request){
        if ($organization){
            $form = $this->createForm(OrganizationType::class, $organization);
            $form->add('submit', SubmitType::class);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $organization = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($organization);
                $entityManager->flush();
                return $this->redirectToRoute("organizations_list");
            }

            return $this->render("organization/form.html.twig", [
                "form" => $form->createView(),
                "organization" => $organization
            ]);
        }
    }

    /**
     * @Route("/organizations/delete/{id}", name="organizations_delete", requirements={"id":"\d+"})
     */
    public function deleteOrganization(Session $session, Organization $organization){
        if ($organization){
            $session->getFlashBag()->add('message', "Deleted organization '{$organization->getName()}' and all related surveys");
            $entityManager = $this->getDoctrine()->getManager();
            foreach($organization->getSurveys() as $survey){
                $entityManager->remove($survey);
            }
            $entityManager->remove($organization);
            $entityManager->flush();
        }
        return $this->redirectToRoute("organizations_list");
    }

    /**
     * @Route("organizations/{id}/surveys", name="organization_surveys", requirements={"id"="\d+"})
     * @
     */
    public function showOrganizationSurveys(int $id){
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find($id);
        $organizationSurveys = $this->getDoctrine()->getRepository(Survey::class)->findBy([
            'organization' => $organization,
        ]);

        return $this->render("organization/surveys.html.twig", [
            "organization" => $organization,
            "surveys" => $organizationSurveys,
        ]);
    }
}