<?php
/**
 * Table.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    15.08.12
 */

namespace Flame\Database\Repository;

use Nette;
use Flame\Database\ITable;

abstract class Base extends \Flame\Database\Repository\Driver
{

	/**
	 * @return \Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->getTable();
	}

	/**
	 * @param array $by
	 * @return \Nette\Database\Table\Selection
	 */
	public function findBy(array $by)
	{
		return $this->getTable()->where($by);
	}

	/**
	 * @param array $by
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function findOneBy(array $by)
	{
		return $this->findBy($by)->limit(1)->fetch();
	}

	/**
	 * @param $id
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function find($id)
	{
		return $this->getTable()->get($id);
	}

	/**
	 * @param ITable $table
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function create(ITable $table)
	{
		return $this->getTable()->insert($table->toArray());
	}

	/**
	 * @param ITable $table
	 * @return bool|int
	 */
	public function update(ITable $table)
	{
		if($row = $this->getTable()->get($table->getId())){
			return $row->update($table->toArray());
		}

		return false;
	}

	/**
	 * @param ITable $table
	 * @return bool|int
	 */
	public function delete(ITable $table)
	{
		if($row = $this->getTable()->get($table->getId())){
			return $row->delete();
		}

		return false;
	}

}
