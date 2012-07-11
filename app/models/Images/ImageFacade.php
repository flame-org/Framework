<?php
/**
 * ImageFacade
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Models\Images;

use Flame\Models\Images\Image;

class ImageFacade
{

	private $repository;

	private $entityManager;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository('\Flame\Models\Images\Image');
	}

	public function getOne($id)
	{
		return $this->repository->getOne($id);
	}

	public function getLastImages()
	{
		return $this->repository->findAll();
	}

	public function delete(Image $image)
	{
		$this->entityManager->remove($image);
		$this->entityManager->flush();
		return $this;
	}

	public function persist(Image $image)
	{
		$this->entityManager->persist($image);
		$this->entityManager->flush();
		return $this;
	}
}
