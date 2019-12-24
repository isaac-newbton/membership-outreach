<?php
namespace App\Service\Organization;

use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

class OrganizationSurveysHandler {
	public function getOpenSurveys(Organization $organization, EntityManagerInterface $entityManager){
		// TODO:
	}
	public function getClosedSurveys(Organization $organization, EntityManagerInterface $entityManager){
		// TODO:
	}
}