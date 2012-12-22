<?php
/**
 * ITemplateFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    22.12.12
 */

namespace Flame\Templating;

interface ITemplateFactory
{

	/**
	 * @param  string
	 * @return Template|FileTemplate
	 */
	function create($class = NULL);

}
