<?php
/**
 * Facade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    14.04.13
 */

namespace Flame\Doctrine;

use Nette\Object;

class EntityManager extends Object
{

	/** @var \Kdyby\Doctrine\EntityManager */
	private $entityManager;

	/**
	 * @param \Kdyby\Doctrine\EntityManager $entityManager
	 */
	public function __construct(\Kdyby\Doctrine\EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param $name
	 * @return \Flame\Doctrine\EntityDao
	 */
	public function get($name)
	{
		return $this->entityManager->getDao($name);
	}

	/**
	 * @param $name
	 * @return \Flame\Doctrine\EntityDao
	 */
	public function getRepository($name)
	{
		return $this->entityManager->getRepository($name);
	}

	/**
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function getEntityManager()
	{
		return $this->entityManager;
	}

}
