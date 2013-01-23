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
		'driver' => null,
		'host' => null,
		'dbname' => null,
		'user' => null,
		'password' => null,
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
	 * Creates selector for table.
	 * @param  string
	 * @return \Nette\Database\Table\Selection
	 */
	public function table($table)
	{
		if (!$this->selectionFactory) {
			$this->selectionFactory = new Table\SelectionFactory($this);
		}
		return $this->selectionFactory->create($table);
	}

	/**
	 * @return string
	 */
	protected function createDns()
	{
		return $this->options['driver'] . ':host=' . $this->options['host'] . ';dbname=' . $this->options['dbname'];
	}

}
