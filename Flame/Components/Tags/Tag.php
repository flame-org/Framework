<?php
/**
 * TagControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    28.07.12
 */

namespace Flame\Components\Tags;

class Tag extends \Flame\Application\UI\Control
{
	/**
	 * @var \Flame\Models\Tags\TagFacade
	 */
	private $tagFacade;

	/**
	 * @var \Flame\Models\Options\OptionFacade
	 */
	private $optionFacade;

	/**
	 * @var int
	 */
	private $countOfItems = 35;

	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct($parent, $name)
	{
		parent::__construct($parent, $name);

		$this->tagFacade = $this->presenter->context->TagFacade;
		$this->optionFacade = $this->presenter->context->OptionFacade;
	}

	public function render()
	{
		$this->initCountOfItems();
		$this->template->setFile(__DIR__ . '/Tag.latte');
		$this->template->tags = $this->tagFacade->getLastTags($this->countOfItems);
		$this->template->render();
	}

	private function initCountOfItems()
	{
		$countOfItems = $this->optionFacade->getOptionValue('menu_tags_count');
		if((int) $countOfItems >= 1) $this->countOfItems = (int) $countOfItems;
	}

}
