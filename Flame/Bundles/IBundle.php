<?php
/**
 * IBundle.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.02.13
 */

namespace Flame\Bundles;

interface IBundle
{

	/**
	 * @return array
	 */
	public function getConfigFiles();
}
