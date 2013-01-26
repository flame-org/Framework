<?php
/**
 * BaseRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    12.07.12
 */

namespace Flame\Doctrine\Model;

use Doctrine\ORM\Mapping\ClassMetadata;
use Flame\Doctrine\Entity;

class Repository extends \Doctrine\ORM\EntityRepository implements IRepository
{

	/**
	 * @param \Flame\Doctrine\Entity $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function delete(Entity $entity, $withoutFlush = self::FLUSH)
	{
		$this->_em->remove($entity);
		if(!$withoutFlush) $this->flush();
		return $this;
	}

	/**
	 * @param \Flame\Doctrine\Entity $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function save(Entity $entity, $withoutFlush = self::FLUSH)
	{
		$this->_em->persist($entity);
		if(!$withoutFlush) $this->flush();
		return $this;
	}

	/**
	 * @param \Flame\Doctrine\Entity $entity
	 * @param int $flag
	 * @return \Doctrine\ORM\Mapping\ClassMetadata
	 */
	public function setIdGenerator(Entity $entity, $flag = ClassMetadata::GENERATOR_TYPE_NONE)
	{
		$metadata = $this->_em->getClassMetadata(get_class($entity));
		$metadata->setIdGeneratorType($flag);
		return $metadata;
	}

	/**
	 * @return Repository
	 */
	public function flush()
	{
		$this->_em->flush();
		return $this;
	}

}
