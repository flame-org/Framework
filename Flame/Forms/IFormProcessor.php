<?php
/**
 * Class IFormProcessor
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */

namespace Flame\Forms;

use Nette\Application\UI\Form;

interface IFormProcessor
{

	/**
	 * Attach processor to form
	 *
	 * @param Form $form
	 * @return $this
	 */
	public function attach(Form $form);
}