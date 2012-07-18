<?php
/**
 * ImportForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.07.12
 */

namespace Flame\Forms;

class ImportForm extends \Flame\Application\UI\Form
{

	public function configure()
	{
		$this->addUpload('file', 'XML file:')
			->addRule(self::FILLED);
		$this->addCheckbox('downloadImages', 'Do you want to import images too?')
			->setDefaultValue(1);
		$this->addSubmit('send', 'Import data');
	}

}
