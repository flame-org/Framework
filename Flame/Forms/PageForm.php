<?php
/**
 * PageForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    17.07.12
 */

namespace Flame\Forms;

class PageForm extends \Flame\Application\UI\Form
{

	public function __construct()
	{
		parent::__construct();
	}

	public function configureEdit()
	{
		$this->configure();
		$this->addSubmit('send', 'Edit page');
	}

	public function configureAdd()
	{
		$this->configure();
		$this->addSubmit('send', 'Create page');
	}

	private function configure()
	{

		$this->addText('name', 'Name:', 80)
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('slug', 'Slug:', 80);

		$this->addTextArea('description', 'Description:', 80, 6)
			->addRule(self::MAX_LENGTH, null, 250);

		$this->addTextArea('keywords', 'META keywords:', 80, 6)
			->addRule(self::MAX_LENGTH, null, 250);

		$this->addTextArea('content', 'Content:', 110, 30)
			->addRule(self::FILLED)
			->getControlPrototype()->class('mceEditor');
	}

}
