<?php
/**
 * ITable.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database;

interface ITable
{

	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @param $id
	 * @return ITable
	 */
	public function setId($id);

	/**
	 * @return array
	 */
	public function toArray();

}
