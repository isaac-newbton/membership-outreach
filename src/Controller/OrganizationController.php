<?php

namespace App\Controller;

use App\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}