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

class ImageFacade extends \Nette\Object
{

	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Images\Image');
	}

	public function getOne($id)
	{
		return $this->repository->findOneById($id);
	}

	public function getLastImages()
	{
		return $this->repository->findBy(array(), array('id' => 'DESC'));
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
