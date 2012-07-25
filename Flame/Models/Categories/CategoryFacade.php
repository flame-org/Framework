<?php
/**
 * CategoryFacade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Models\Categories;

class CategoryFacade extends \Nette\Object
{
	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Categories\Category');
	}

	public function getOne($id)
	{
		return $this->repository->findOneById($id);
	}

	public function getOneByName($name)
	{
		return $this->repository->findOneBy(array('name' => (string) $name));
	}

	public function getLastCategories()
	{
		return $this->repository->findBy(array(), array('id' => 'DESC'));
	}

	public function persist(Category $category)
	{
		return $this->repository->save($category);
	}

	public function delete(Category $category)
	{
		return $this->repository->delete($category);
	}

}
