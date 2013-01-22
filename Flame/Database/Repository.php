<?php
/**
 * Table.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    15.08.12
 */

namespace Flame\Database;

use Nette;

abstract class Repository extends Nette\Object
{

	/**
	 * @var Nette\Database\Connection
	 */
	protected $connection;

	/**
	 * @var string
	 */
	protected $tableName;

	/**
	 * @param Nette\Database\Connection $db
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(Nette\Database\Connection $db)
	{
		$this->connection = $db;

		if ($this->tableName === null)
			throw new Nette\InvalidStateException('Name of table must be defined ' . __CLASS__ .'::' . $this->tableName);
	}

	/**
	 * @return \Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->connection->table($this->tableName);
	}

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
