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
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \Doctrine\ORM\Mapping\ClassMetadata $class
	 */
	public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class)
	{
		parent::__construct($em, $class);
		$this->entityManager = $em;
	}

	/**
	 * @param $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function delete($entity, $withoutFlush = self::FLUSH)
	{
		$this->entityManager->remove($entity);
		if(!$withoutFlush) $this->entityManager->flush();
		return $this;
	}

	/**
	 * @param $entity
	 * @param bool $withoutFlush
	 * @return Repository
	 */
	public function save($entity, $withoutFlush = self::FLUSH)
	{
		$this->entityManager->persist($entity);
		if(!$withoutFlush) $this->entityManager->flush();
		return $this;
	}

}
