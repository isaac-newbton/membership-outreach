<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

trait EntityIdTrait{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @var UuidInterface
	 *
	 * @ORM\Column(type="uuid", unique=true)
	 */
	protected $uuid;

	public function getId(): ?int{
		return $this->id;
	}

	public function getUuid(): UuidInterface{
		return $this->uuid;
	}
}