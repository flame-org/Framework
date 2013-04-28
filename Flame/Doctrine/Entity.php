<?php
/**
 * BaseEntity.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    14.04.13
 */

namespace Flame\Doctrine;

use Kdyby\Doctrine\Entities\IdentifiedEntity;

abstract class Entity extends IdentifiedEntity
{

	/**
	 * @return array
	 */
	public function toArray()
	{
		return array_merge(array('id' => $this->getId()), get_object_vars($this));
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		if (isset($this->name) && $this->name !== null) {
			return (string)$this->name;
		} else {
			return (string)$this->id;
		}
	}

}
