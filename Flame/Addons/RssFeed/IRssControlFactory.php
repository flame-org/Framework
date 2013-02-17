<?php
/**
 * IRssControlFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    17.02.13
 */

namespace Flame\Addons\RssFeed;

interface IRssControlFactory
{

	/**
	 * @return RssControl
	 */
	public function create();

}
