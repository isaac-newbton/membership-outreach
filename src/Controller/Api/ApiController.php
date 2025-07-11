<?php

namespace App\Controller\Api;

use App\Entity\ApiKey;
use App\Entity\Organization;
use App\Entity\PostedContent;
use App\Entity\PostedContentHit;
use App\Repository\ApiKeyRepository;
use App\Repository\OrganizationRepository;
use App\Repository\PostedContentRepository;
use App\Service\Api\ApiKeyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController{
	/**
	 * @var ApiKeyHandler
	 */
	private $apiKeyHandler;

	public function __construct(ApiKeyHandler $apiKeyHandler){
		$this->apiKeyHandler = $apiKeyHandler;
	}

	/**
	 * @Route("/api", name="api_home")
	 */
	public function apiHome(ApiKeyRepository $apiKeyRepository){
		$keys = $apiKeyRepository->findAll();
		return $this->render('api/keys.html.twig', [
			'keys'=>$keys
		]);
	}

	/**
	 * @Route("/api/testkey/{key}", name="api_test_key")
	 */
	public function testKey(string $key){
		$valid = $this->apiKeyHandler->isValidKey($key);
		return new Response(
			"<html><body><h1>$key is " . ($valid ? '' : 'NOT ') . "valid</h1></body></html>"
		);
	}

	/**
	 * @Route("/api/key/create", name="api_create_key")
	 */
	public function createKey(){
		$key = new ApiKey();
		$em = $this->getDoctrine()->getManager();
		$em->persist($key);
		$em->flush();
		return $this->redirectToRoute('api_home');
	}

	/**
	 * @Route("/api/key/delete/{id}", name="api_delete_key")
	 */
	public function deleteKey(int $id, ApiKeyRepository $repository){
		$key = $repository->find($id);
		if($key){
			$em = $this->getDoctrine()->getManager();
			$em->remove($key);
			$em->flush();
		}
		return $this->redirectToRoute('api_home');
	}

	/**
	 * @Route("/api/v1/{key}/orgs/all", methods={"GET"}, name="api_all_orgs")
	 */
	public function allOrgs(string $key, OrganizationRepository $organizationRepository){
		if($this->apiKeyHandler->isValidKey($key)){
			$organizations = $organizationRepository->findAll();
			return new JsonResponse(['organizations'=>array_map(function($organization){
				/**
				 * @var Organization
				 */
				$org = $organization;
				$tags = $org->getTags();
				$tags_array = [];
				$badges_array = [];
				if($tags && !empty($tags)){
					foreach($tags as $tag){
						$tags_array[] = [
							'name'=>$tag->getName(),
							'description'=>$tag->getDescription()
						];
					}
				}
				return [
					'id'=>$org->getCustomId(),
					'name'=>$org->getName(),
					'website'=>$org->getDirectoryUrl(),
					'address'=>[
						'street1'=>$org->getStreetAddress1(),
						'street2'=>$org->getStreetAddress2(),
						'city'=>$org->getCity(),
						'state'=>$org->getState(),
						'postal'=>$org->getPostalCode()
					],
					'contact'=>[
						'name'=>$org->getContactPerson(),
						'email'=>$org->getContactEmail(),
						'phone'=>$org->getContactPhoneNumber(),
						'fax'=>$org->getContactFax(),
						'other_phone'=>$org->getContactOtherNumber()
					],
					'tags'=>$tags_array,
					'badges'=>$badges_array
				];
			}, $organizations)], 200);
		}else{
			return new JsonResponse(['error'=>'invalid key'], 401);
		}
	}

	/**
	 * @Route("/api/v1/{key}/orgs/{customId}", methods={"GET"}, name="api_org_details_custom_id")
	 */
	public function orgDetailsCustomId(string $key, string $customId, OrganizationRepository $organizationRepository){
		if($this->apiKeyHandler->isValidKey($key)){
			if(empty($customId)){
				return new JsonResponse(['error'=>'invalid id'], 401);
			}
			/**
			 * @var Organization|null
			 */
			$organization = $organizationRepository->findOneBy([
				'custom_id'=>$customId
			]);
			if(!$organization){
				return new JsonResponse(['error'=>'organization not found'], 404);
			}
			$tags = $organization->getTags();
			$tags_array = [];
			$badges_array = [];
			if($tags && !empty($tags)){
				foreach($tags as $tag){
					$tags_array[] = [
						'name'=>$tag->getName(),
						'description'=>$tag->getDescription()
					];
				}
			}
			return new JsonResponse(['organization'=>[
				'id'=>$organization->getCustomId(),
				'name'=>$organization->getName(),
				'website'=>$organization->getDirectoryUrl(),
				'address'=>[
					'street1'=>$organization->getStreetAddress1(),
					'street2'=>$organization->getStreetAddress2(),
					'city'=>$organization->getCity(),
					'state'=>$organization->getState(),
					'postal'=>$organization->getPostalCode()
				],
				'contact'=>[
					'name'=>$organization->getContactPerson(),
					'email'=>$organization->getContactEmail(),
					'phone'=>$organization->getContactPhoneNumber(),
					'fax'=>$organization->getContactFax(),
					'other_phone'=>$organization->getContactOtherNumber()
				],
				'tags'=>$tags_array,
				'badges'=>$badges_array
			]], 200);
		}else{
			return new JsonResponse(['error'=>'invalid key'], 401);
		}
	}

	/**
	 * @Route("/api/v1/{key}/content", methods={"POST"}, name="api_create_posted_content")
	 */
	public function createPostedContent(Request $request, string $key, PostedContentRepository $postedContentRepository, OrganizationRepository $organizationRepository){
		if($this->apiKeyHandler->isValidKey($key)){
			if(!$externalId = $request->request->get('id', false)){
				return new JsonResponse(['error'=>'id is required'], 401);
			}
			if(!$orgCustomId = $request->request->get('organization', false)){
				return new JsonResponse(['error'=>'organization is required'], 401);
			}
			/**
			 * @var Organization
			 */
			if(!$organization = $organizationRepository->findOneBy([
				'custom_id'=>$orgCustomId
			])){
				return new JsonResponse(['error'=>'organization not found'], 404);
			}
			if($existingPostedContent = $postedContentRepository->findOneBy([
				'organization'=>$organization,
				'externalId'=>$externalId
			])){
				return new JsonResponse(['error'=>'that organization already has content with that id'], 403);
			}

			$em = $this->getDoctrine()->getManager();
			/**
			 * @var PostedContent
			 */
			$postedContent = new PostedContent();
			$postedContent->setExternalId($externalId);
			$postedContent->setTitle($request->request->get('title'));
			$postedContent->setPermalink($request->request->get('permalink'));
			$postedContent->setContent($request->request->get('content'));
			if(($meta = $request->request->get('meta', false))){
				$meta = json_decode($meta, true);
				if(is_array($meta) && !empty($meta)){
					$postedContent->setMeta($meta);
				}
			}
			$organization->addPostedContent($postedContent);
			$em->persist($postedContent);
			$em->persist($organization);
			$em->flush();

			return new JsonResponse(['postedContent'=>[
				'uuid'=>$postedContent->getUuid()
			]], 200);
		}else{
			return new JsonResponse(['error'=>'invalid key'], 401);
		}
	}

	/**
	 * @Route("/api/v1/{key}/content/{uuid}/hit/{type}", methods={"GET"}, name="api_hit_posted_content")
	 */
	public function hitPostedContent(Request $request, string $key, string $uuid, string $type, PostedContentRepository $postedContentRepository){
		if($this->apiKeyHandler->isValidKey($key)){
			if(!$postedContent = $postedContentRepository->findOneBy(['uuid'=>$uuid])){
				return new JsonResponse(['error'=>'posted content not found'], 404);
			}
			
			$em = $this->getDoctrine()->getManager();
			/**
			 * @var PostedContentHit
			 */
			$postedContentHit = new PostedContentHit();
			$postedContentHit->setType($type);
			$postedContentHit->setPostedContent($postedContent);
			$params = $request->query->all();
			if(is_array($params) && !empty($params)){
				$postedContentHit->setMeta($params);
			}
			$em->persist($postedContentHit);
			$em->flush();

			return new JsonResponse(['postedContentHit'=>[
				'uuid'=>$postedContentHit->getUuid()
			]], 200);
		}else{
			return new JsonResponse(['error'=>'invalid key'], 401);
		}
	}
}