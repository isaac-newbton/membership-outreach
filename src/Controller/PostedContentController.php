<?php

namespace App\Controller;

use App\Repository\PostedContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostedContentController extends AbstractController{
	/**
	 * @Route("/content/{uuid}", name="content_details")
	 */
	public function contentDetails(string $uuid, PostedContentRepository $postedContentRepository){

		if(!$postedContent = $postedContentRepository->findOneBy([
			'uuid'=>$uuid
		])){
			return $this->redirectToRoute('dashboard');
		}

		$hits = $postedContent->getPostedContentHits();
		$readHits = [];
		$clickHits = [];

		if($hits){
			foreach($hits as $hit){
				switch($hit->getType()){
					case 'read':
						$readHits[] = $hit;
					break;
					case 'click':
						$clickHits[] = $hit;
					break;
					default:
					break;
				}
			}
		}

		return $this->render('posted_content/details.html.twig', [
			'postedContent'=>$postedContent,
			'hits'=>$hits,
			'readHits'=>$readHits,
			'clickHits'=>$clickHits
		]);
	}
}