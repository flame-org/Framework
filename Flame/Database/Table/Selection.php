<?php
/**
 * Selection.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database\Table;

use Nette;

class Selection extends \Nette\Database\Table\Selection
{

	/**
	 * @var string
	 */
	private $tableClass;

	/**
	 * @param \Nette\Database\Connection $connection
	 * @param strign $table
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
	 * @return \Nette\Database\Table\ActiveRow|void
	 */
	protected function createRow(array $row)
	{
		$re = new \ReflectionClass($this->tableClass);
		$re = $re->newInstanceWithoutConstructor();
		if(count($row)){
			foreach($row as $key => $value){
				$methodName = 'set' . ucfirst($key);
				$re->$methodName($value);
			}
		}
		return $re;
	}

}
