<?php
/**
 * IComponentController.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.12.12
 */

namespace Flame\Application\UI\Components;

use Nette\Application\UI;

interface IComponentController
{

	/**
	 * @return UI\Control|UI\Form
	 */
	public function getComponent();
}
