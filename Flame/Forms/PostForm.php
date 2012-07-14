<?php
/**
 * PostForm.php
 *
 * @author  Jiří Šifalda <jsifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Forms;

class PostForm extends \Nette\Apllication\UI\Form
{

	public function __construct()
	{
		parent::__construct();
	}

	public function configureAdd()
	{
		$this->configure();
		$this->addCheckbox('comment', 'Allow comments?')
			->setDefaultValue('1');
		$this->addSubmit('create', 'Create post');

	}

	public function configureEdit(array $defaults)
	{
		$this->configure();
		$this->setDefaults($defaults);
		$this->addCheckbox('comment', 'Allow comments?');
		$this->addSubmit('edit', 'Edit post');

	}

	private function configure()
	{
		$this->addText('name', 'Name:', 80)
			->addRule(self::FILLED, 'Name is required.')
			->addRule(self::MAX_LENGTH, 'Name of post must be shorter than %d chars', 100);

		$this->addText('slug', 'Name in URL', 80)
			->addRule(self::MAX_LENGTH, 'Name in URL must be shorter than %d chars', 100);

		$this->addText('keywords', 'META Keywords', 80)
			->addRule(self::MAX_LENGTH, 'Meta keywords must be shorter than %d chars', 500);

		$this->addTextArea('description', 'Descriptions', 90, 5)
			->addRule(self::MAX_LENGTH, 'Descriptions must be shorter than %d chars', 250);

		$this->addTextArea('content', 'Content:', 115, 35)
			->addRule(self::FILLED, 'Content is required.')
			->getControlPrototype()->class('mceEditor');

		$this->addCheckbox('publish', 'Make this post published?');

		$this->onSuccess[] = callback($this->getPresenter(), 'postFormSubmitted');
	}
}
