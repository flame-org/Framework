<?php
/**
 * Facade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.08.12
 */

namespace Flame\Model;

abstract class Facade extends \Nette\Object implements \Flame\Model\IFacade
{

	/**
	 * @var \Doctrine\ORM\EntityRepository
	 */
	protected $repository;

	/**
	 * @var string
	 */
	protected $repositoryName;

	/**
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{

		if ($this->repositoryName === NULL) {
			$class = get_class($this);
			throw new \Nette\InvalidStateException("Name of repository must be defined $class::\$reposityName.");
		}

		$this->repository = $entityManager->getRepository($this->repositoryName);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getOne($id)
	{
		return $this->repository->finOneById($id);
	}

	/**
	 * @param \Flame\Doctrine\IEntity $reference
	 * @return mixed
	 */
	public function save(\Flame\Doctrine\IEntity $reference)
	{
		return $this->repository->save($reference);
	}

	/**
	 * @param \Flame\Doctrine\IEntity $reference
	 * @return mixed
	 */
	public function delete(\Flame\Doctrine\IEntity $reference)
	{
		return $this->repository->delete($reference);
	}

}
