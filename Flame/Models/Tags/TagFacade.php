<?php
/**
 * TagFacade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Models\Tags;

class TagFacade
{
	private $repository;
	
	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Tags\Tag');
	}

	public function getOne($id)
	{
		return $this->repository->findOneById($id);
	}

	public function getOneByName($name)
	{
		return $this->repository->findOneBy(array('name' => (string) $name));
	}

	public function getLastTags()
	{
		return $this->repository->findBy(array(), array('id' => 'DESC'));
	}

	public function persist(Tag $tag)
	{
		return $this->repository->save($tag);
	}

	public function delete(Tag $tag)
	{
		return $this->repository->delete($tag);
	}
}
