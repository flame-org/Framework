<?php
/**
 * Driver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    23.01.13
 */

namespace Flame\Database\Repository;

use Flame\Utils\Strings;

abstract class Driver extends \Nette\Object
{

	/**
	 * @var \Flame\Database\Connection
	 */
	protected $connection;

	/**
	 * @var string
	 */
	protected $repositoryName;

	/**
	 * @var string
	 */
	private $tableName;

	/**
	 * @param \Flame\Database\Connection $db
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(\Flame\Database\Connection $db)
	{
		$this->connection = $db;
		$this->tableName = $this->getTableName();

		if ($this->repositoryName === null)
			throw new \Nette\InvalidStateException('Name of repository must be defined ' . __CLASS__ .'::' . $this->repositoryName);
	}

	/**
	 * @return string
	 */
	public function getRepositoryName()
	{
		return $this->repositoryName;
	}

	/**
	 * @return string
	 */
	public function getTableName()
	{
		if($this->tableName === null){
			$name = $this->repositoryName;
			if(Strings::contains($this->repositoryName, '\\')){
				$name = $this->getTablePrefix() . Strings::getLastPiece($this->repositoryName, '\\', true, false);
			}
			$this->tableName = strtolower($name);
		}

		return $this->tableName;
	}

	/**
	 * @return null
	 */
	public function getTablePrefix()
	{
		$options = $this->connection->getOptions();
		return (isset($options['prefix'])) ? $options['prefix'] : null;
	}


	/**
	 * @return \Flame\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->connection->repository($this->tableName, $this->repositoryName);
	}

}
