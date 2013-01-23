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

}
