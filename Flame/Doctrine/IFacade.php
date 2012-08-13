<?php
/**
 * IFacade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    13.08.12
 */

namespace Flame\Doctrine;

interface IFacade
{

	public function __construct(\Doctrine\ORM\EntityManager $entityManager);

	public function getOne($id);

}
