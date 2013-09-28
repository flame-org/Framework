<?php
/**
 * Class FlashMessageControlFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.09.13
 */
namespace Flame\Addons\FlashMessages;

class FlashMessageControlFactory implements IFlashMessageControlFactory
{

	/**
	 * @param null $templateFile
	 * @return FlashMessageControl
	 */
	public function create($templateFile = null)
	{
		return new FlashMessageControl($templateFile);
	}
}