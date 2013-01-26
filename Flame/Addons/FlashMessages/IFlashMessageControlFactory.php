<?php
/**
 * IFlashMessageControlFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    26.01.13
 */

namespace Flame\Addons\FlashMessages;

interface IFlashMessageControlFactory
{

	/**
	 * @param null $templateFile
	 * @return FlashMessageControl
	 */
	public function create($templateFile = null);

}
