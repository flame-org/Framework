<?php
/**
 * Selection.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    22.01.13
 */

namespace Flame\Database\Table;

class Selection extends \Nette\Database\Table\Selection
{

	/**
	 * @param array $row
	 * @return \Nette\Database\Table\ActiveRow|void
	 */
	protected function createRow(array $row)
	{
		$re = new \ReflectionClass('\Sharezone\Model\Subscriptions\Subscribe');
		$re = $re->newInstanceWithoutConstructor();
		if(count($row)){
			foreach($row as $key => $value){
				$methodName = 'set' . lcfirst($key);
				$re->$methodName($value);
			}
		}

		return $re;
	}

}
