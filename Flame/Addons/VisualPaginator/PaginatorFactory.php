<?php
/**
 * Class PaginatorFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Addons\VisualPaginator;

use Nette\Object;

class PaginatorFactory extends Object implements IPaginatorFactory
{

	/**
	 * @return Paginator
	 */
	public function create()
	{
		return new Paginator;
	}
}