<?php
/**
 * BaseRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    12.07.12
 */

namespace Flame\Model;

class Repository extends \Doctrine\ORM\EntityRepository implements IRepository
{

	/**
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \Doctrine\ORM\Mapping\ClassMetadata $class
	 */
	public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\Mapping\ClassMetadata $class)
	{
		parent::__construct($em, $class);
	}

	/**
	 * @param $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function delete(\Flame\Model\IEntity $entity, $withoutFlush = self::FLUSH)
	{
		$this->_em->remove($entity);
		if(!$withoutFlush) $this->_em->flush();
		return $this;
	}

	/**
	 * @param $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function save(\Flame\Model\IEntity $entity, $withoutFlush = self::FLUSH)
	{
		$this->_em->persist($entity);
		if(!$withoutFlush) $this->_em->flush();
		return $this;
	}

	/**
	 * @return Repository
	 */
	public function flush()
	{
		$this->_em->flush();
		return $this;
	}

	/**
	 * @param IEntity $entity
	 */
	public function setIdGeneratorTypeNone(\Flame\Model\IEntity $entity)
	{
		$metadata = $this->_em->getClassMetadata(get_class($entity));
		$metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
	}

}
