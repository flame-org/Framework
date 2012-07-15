<?php
/**
 * TagForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    15.07.12
 */

namespace Flame\Forms;

class TagForm extends \Flame\Application\UI\Form
{

	public function configureAdd()
	{
		$this->configure();
		$this->addSubmit('send', 'create');
	}

	public function configureEdit(array $defaults)
	{
		$this->configure();
		$this->setDefaults($defaults);
		$this->addSubmit('send', 'edit');
	}

	private function configure()
	{
		$this->addText('name', 'Name:')
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('slug', 'Slug:')
			->addRule(self::MAX_LENGTH, null, 100);
	}

}
