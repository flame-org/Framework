<?php
/**
 * IFacade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    13.08.12
 */

namespace Flame\Doctrine\Model;

interface IFacade
{

	/**
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function __construct(\Doctrine\ORM\EntityManager $entityManager);

	/**
	 * @param $id
	 * @return \Flame\Doctrine\Entity
	 */
	public function getOne($id);

}
