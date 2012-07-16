<?php
/**
 * PostForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Forms;

class PostForm extends \Flame\Application\UI\Form
{
	private $categories;

	private $tags;

	public function __construct(array $categories, array $tags)
	{
		parent::__construct();

		$this->categories = $this->prepareForFormItem($categories);
		$this->tags = $this->prepareForFormItem($tags);
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
		$this->setDefaults($this->prepareDefaultValues($defaults));
		$this->addCheckbox('comment', 'Allow comments?');
		$this->addSubmit('edit', 'Edit post');

	}

	private function configure()
	{
		$this->addText('name', 'Name:', 80)
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('slug', 'Name in URL', 80)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('keywords', 'META Keywords', 80)
			->addRule(self::MAX_LENGTH, null, 500);

		$this->addTextArea('description', 'Descriptions', 90, 5)
			->addRule(self::MAX_LENGTH, null, 250);

		$this->addTextArea('content', 'Content:', 115, 35)
			->addRule(self::FILLED)
			->getControlPrototype()->class('mceEditor');

		$this->addSelect('category', 'Category:', $this->categories)
			->addRule(self::FILLED);

		$this->addMultiSelect('tags', 'Tags:', $this->tags);

		$this->addCheckbox('publish', 'Make this post published?');
	}

	private function prepareDefaultValues(array $defaults)
	{
		if(isset($defaults['category'])){
			$defaults['category'] = $defaults['category']->id;
		}

		if(isset($defaults['tags'])){

			$tags = $defaults['tags']->toArray();

			if(is_array($tags) and count($tags)){
				$prepared = array();
				foreach($tags as $tag){
					$prepared[] = $tag->id;
				}
				$defaults['tags'] = $prepared;
			}

		}

		return $defaults;
	}
}
