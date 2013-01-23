<?php
/**
 * SelectionFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database\Table;

use Nette;

class SelectionFactory extends \Nette\Object
{
	/** @var Nette\Database\Connection */
	private $connection;

	/** @var Nette\Database\IReflection */
	private $reflection;

	/** @var Nette\Caching\IStorage */
	private $cacheStorage;

	/**
	 * @param \Nette\Database\Connection $connection
	 * @param \Nette\Database\IReflection $reflection
	 * @param \Nette\Caching\IStorage $cacheStorage
	 */
	public function __construct(Nette\Database\Connection $connection, Nette\Database\IReflection $reflection = null, Nette\Caching\IStorage $cacheStorage = null)
	{
		$this->connection = $connection;
		$this->reflection = $reflection ?: new Nette\Database\Reflection\ConventionalReflection;
		$this->cacheStorage = $cacheStorage;
	}

	/**
	 * @param $table
	 * @param $tableClass
	 * @return Selection
	 */
	public function create($table, $tableClass)
	{
		return new Selection($this->connection, $table, $tableClass, $this->reflection, $this->cacheStorage);
	}

}
