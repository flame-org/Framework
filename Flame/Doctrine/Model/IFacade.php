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
	 * @param $id
	 * @return \Flame\Doctrine\Entity
	 */
	public function getOne($id);

	/**
	 * @param \Flame\Doctrine\Entity $reference
	 * @param bool $flush
	 * @return mixed
	 */
	public function save(\Flame\Doctrine\Entity $reference, $flush = true);

	/**
	 * @param \Flame\Doctrine\Entity $reference
	 * @param bool $flush
	 * @return mixed
	 */
	public function delete(\Flame\Doctrine\Entity $reference, $flush = true);

}
