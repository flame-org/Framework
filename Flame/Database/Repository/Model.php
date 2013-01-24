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

abstract class Model extends \Flame\Database\Repository\Driver
{

	/**
	 * @return \Flame\Database\Table\Selection
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
	 * @return \Flame\Database\Table
	 */
	public function findOneBy(array $by)
	{
		return $this->findBy($by)->limit(1)->fetch();
	}

	/**
	 * @param $id
	 * @return \Flame\Database\Table
	 */
	public function find($id)
	{
		return $this->getTable()->get($id);
	}

	/**
	 * @param \Flame\Database\ITable $table
	 * @return \Flame\Database\Table
	 */
	public function create(ITable $table)
	{
		return $this->getTable()->insert($table->toArray());
	}

	/**
	 * @param \Flame\Database\ITable $table
	 * @return mixed
	 */
	public function update(ITable $table)
	{
		return $table->update($table->toArray());
	}

	/**
	 * @param \Flame\Database\ITable $table
	 * @return mixed
	 */
	public function delete(ITable $table)
	{
		return $table->delete();
	}

}
