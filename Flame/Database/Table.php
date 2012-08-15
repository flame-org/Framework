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

abstract class Table extends Nette\Object
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

		if ($this->tableName === NULL) {
			$class = get_class($this);
			throw new Nette\InvalidStateException("Name of table must be defined $class::\$tableName.");
		}
	}


	/**
	 * @return mixed
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

}
