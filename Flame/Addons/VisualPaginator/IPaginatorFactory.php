<?php
/**
 * IPaginatorFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.12.12
 */

namespace Flame\Addons\VisualPaginator;

interface IPaginatorFactory
{

	/**
	 * @return Paginator
	 */
	public function create();

}
