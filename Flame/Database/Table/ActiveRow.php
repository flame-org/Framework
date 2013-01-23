<?php
/**
 * ActiveRow.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    23.01.13
 */

namespace Flame\Database\Table;

class ActiveRow extends \Nette\Database\Table\ActiveRow
{

	public function __construct()
	{

	}

	/**
	 * @param array $data
	 * @param Selection $table
	 */
	public function initParent(array $data, Selection $table)
	{
		parent::__construct($data, $table);
	}

}
