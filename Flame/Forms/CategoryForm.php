<?php
/**
 * CategoryForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    15.07.12
 */

namespace Flame\Forms;

class CategoryForm extends \Flame\Application\UI\Form
{

	private $categories;

	public function __construct(array $categories)
	{
		parent::__construct();
		$this->categories = $this->prepareForFormItem($categories);
	}


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
		$this->addText('name', 'Name:', 50)
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('slug', 'Slug:', 50)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addSelect('parent', 'In category:', $this->categories)
			->setPrompt('-- No parent category --');

		$this->addTextArea('description', 'Description')
			->addRule(self::MAX_LENGTH, null, 250);
	}

}
