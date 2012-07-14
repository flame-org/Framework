<?php
/**
 * BaseRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    12.07.12
 */

namespace Flame\Doctrine;

class BaseRepository extends \Doctrine\ORM\EntityRepository implements IRepository
{

	protected $entityManager;

	public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class)
	{
		parent::__construct($em, $class);
		$this->entityManager = $em;
	}

	public function delete($entity, $withoutFlush = self::FLUSH)
	{
		$this->entityManager->remove($entity);
		if(!$withoutFlush) $this->entityManager->flush();
		return $this;
	}

	public function save($entity, $withoutFlush = self::FLUSH)
	{
		$this->entityManager->persist($entity);
		if(!$withoutFlush) $this->entityManager->flush();
		return $this;
	}

}
