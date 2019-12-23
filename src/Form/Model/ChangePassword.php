<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword{
	/**
	 * @SecurityAssert\UserPassword(
	 * 	message="Invalid password"
	 * )
	 */
	protected $oldPassword;

	/**
	 * @Assert\Length(
	 * 	min = 8,
	 * 	minMessage = "Password must be at least 8 characters"
	 * )
	 */
	protected $newPassword;

	/**
	 * @return mixed
	 */
	public function getOldPassword(){
		return $this->oldPassword;
	}

	/**
	 * @param mixed $oldPassword
	 */
	public function setOldPassword($oldPassword){
		$this->oldPassword = $oldPassword;
	}

	/**
	 * @return mixed
	 */
	public function getNewPassword(){
		return $this->newPassword;
	}

	/**
	 * @param mixed $newPassword
	 */
	public function setNewPassword($newPassword){
		$this->newPassword = $newPassword;
	}
}