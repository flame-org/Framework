<?php
/**
 * Selection.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database\Table;

use Nette;
use PDO;

class Selection extends \Nette\Database\Table\Selection
{

	/**
	 * @var string
	 */
	private $tableClass;

	/**
	 * @param \Nette\Database\Connection $connection
	 * @param string $table
	 * @param string $tableClass
	 * @param \Nette\Database\IReflection $reflection
	 * @param \Nette\Caching\IStorage $cacheStorage
	 */
	public function __construct(
		Nette\Database\Connection $connection,
		$table,
		$tableClass,
		Nette\Database\IReflection $reflection,
		Nette\Caching\IStorage $cacheStorage = null
	)
	{
		parent::__construct($connection, $table, $reflection, $cacheStorage);

		$this->tableClass = $tableClass;

	}

	/**
	 * @param array $row
	 * @return \Flame\Database\Table|\Nette\Database\Table\ActiveRow
	 */
	protected function createRow(array $row)
	{
		$re = new \ReflectionClass($this->tableClass);
		/** @var $table \Flame\Database\Table */
		$table = $re->newInstanceArgs($this->getTableClassParameters($row, $re));
		//$table = $re->newInstanceWithoutConstructor(); #PHP 5.4 only
		$table = $this->setTableProperties($row, $table);
		$table->initParent($row, $this);
		return $table;
	}

	/**
	 * @param array $row
	 * @param \ReflectionClass $class
	 * @return array
	 */
	private function getTableClassParameters(array $row, \ReflectionClass $class)
	{
		$invokeParametes = array();
		if($class->isInstantiable()){
			$parameters = $class->getConstructor()->getParameters();

			if(count($parameters)){
				foreach($parameters as $parameter){
					if($parameter instanceof \ReflectionParameter and isset($row[$parameter->getName()]))
						$invokeParametes[] = $row[$parameter->getName()];
				}
			}

			if(count($parameters) !== count($invokeParametes))
				throw new \Nette\InvalidStateException('Name of parameters in ' . $class->getName() . ' must be used from name of properties');
		}
		return $invokeParametes;
	}

	/**
	 * @param \Flame\Database\Table $table
	 * @param array $row
	 * @return \Flame\Database\Table
	 */
	private function setTableProperties(array $row, \Flame\Database\Table $table)
	{
		if(count($row)){
			foreach($row as $key => $value){
				$methodName = 'set' . ucfirst($key);
				$table->$methodName($value);
			}
		}

		return $table;
	}
}
