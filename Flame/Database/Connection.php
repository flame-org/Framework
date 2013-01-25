<?php
/**
 * Connection.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database;

class Connection extends \Nette\Database\Connection
{

	/**
	 * @var \Flame\Database\Table\SelectionFactory
	 */
	private $selectionFactory;

	/**
	 * @var array
	 */
	private $options = array(
		'driver' => 'mysql',
		'host' => null,
		'dbname' => null,
		'user' => null,
		'password' => null,
		'prefix' => null,
		'options' => array(),
		'driver_class' => null
	);

	/**
	 * @param array $options
	 */
	public function __construct(array $options)
	{
		$this->options = array_merge($this->options, $options);
		parent::__construct(
			$this->createDns(),
			$this->options['user'],
			$this->options['password'],
			$this->options['options'],
			$this->options['driver_class']
		);
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * @param \Nette\Database\Table\SelectionFactory $selectionFactory
	 * @return Connection|\Nette\Database\Connection
	 */
	public function setSelectionFactory(\Nette\Database\Table\SelectionFactory $selectionFactory)
	{
		$this->selectionFactory = $selectionFactory;
		return $this;
	}

	/**
	 * @param $table
	 * @param $tableClass
	 * @return Table\Selection
	 */
	public function repository($table, $tableClass)
	{
		if (!$this->selectionFactory) {
			$this->selectionFactory = new Table\SelectionFactory($this);
		}
		return $this->selectionFactory->create($table, $tableClass);
	}

	/**
	 * @return string
	 */
	protected function createDns()
	{
		return $this->options['driver'] . ':host=' . $this->options['host'] . ';dbname=' . $this->options['dbname'];
	}

}
