<?php
/**
 * EntityDao.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.04.13
 */

namespace Flame\Doctrine;

use Nette\Reflection\ClassType;

class EntityDao extends \Kdyby\Doctrine\EntityDao
{

	/**
	 * @return \Sharezone\Doctrine\Entity
	 */
	public function createEntity()
	{
		$reflection = new ClassType($this->getEntityName());

		return $reflection->newInstanceArgs(func_get_args());
	}

	/**
	 * @return \Sharezone\Doctrine\Entity
	 */
	public function addNewEntity()
	{
		$reflection = new ClassType($this->getEntityName());
		$entity = $reflection->newInstanceArgs(func_get_args());
		$this->add($entity);

		return $entity;
	}

}
