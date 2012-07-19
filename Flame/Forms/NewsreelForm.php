<?php
/**
 * NewsreelForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    17.07.12
 */

namespace Flame\Forms;

class NewsreelForm extends \Flame\Application\UI\Form
{

	public function __construct()
	{
		parent::__construct();
	}

	public function configureAdd()
	{
		$this->configure();
		$this->addSubmit('Create', 'Create newsreel');
	}

	public function configureEdit()
	{
		$this->configure();
		$this->addSubmit('Edit', 'Edit newsreel');
	}

	private function configure()
	{
		$this->addText('title', 'Title:', 100)
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 100);
		$this->addTextArea('content', 'Content:', 99, 20)
			->addRule(self::FILLED)
			->getControlPrototype()->class('mceEditor');
		$this->addDatePicker('date', 'Date:')
			->setDefaultValue(new \DateTime())
			->addRule(self::VALID, 'Entered date is not valid')
			->addRule(self::FILLED);
	}
}
