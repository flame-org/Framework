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

class ImageFacade
{

	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Images\Image');
	}

	public function getOne($id)
	{
		return $this->repository->findOneBy(array('id' => (int)$id));
	}

	public function getLastImages()
	{
		return $this->repository->findAll();
	}

	public function delete(Image $image)
	{
		return $this->repository->delete($image);
	}

	public function persist(Image $image)
	{
		return $this->repository->save($image);
	}
}
