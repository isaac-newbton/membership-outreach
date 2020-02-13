<?php
namespace App\Service\Api;

use App\Entity\ApiKey;
use App\Repository\ApiKeyRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiKeyHandler {
	/**
	 * @var ApiKeyRepository|null
	 */
	private $apiKeyRepository;

	public function __construct(ApiKeyRepository $apiKeyRepository){
		$this->apiKeyRepository = $apiKeyRepository;
	}

	public function isValidKey(string $contents){
		/**
		 * @var ApiKey|null
		 */
		$key = $this->apiKeyRepository->findOneByContents($contents);
		if($key && $key->getEnabled()){
			return $contents===$key->getContents();
		}
		return false;
	}
}