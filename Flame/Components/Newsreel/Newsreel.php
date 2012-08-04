<?php

namespace Flame\Components\Newsreel;

class Newsreel extends \Flame\Application\UI\Control
{
	/**
	 * @var \Flame\Models\Newsreel\NewsreelFacade
	 */
	private $newsreelFacade;
	
	/**
	 * @var \Flame\Models\Options\OptionFacade
	 */
	private $optionFacade;
	
	/**
	 * @var int
	 */
    private $itemsInNewsreelMenuList = 3;
	
	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct($parent, $name)
	{
		parent::__construct($parent, $name);

		$this->newsreelFacade = $this->presenter->context->NewsreelFacade;
		$this->optionFacade = $this->presenter->context->OptionFacade;
	}

	public function render()
	{
		$this->initCountOfItems();
		$this->template->setFile(__DIR__ . '/Newsreel.latte');
		$this->template->newsreels = $this->newsreelFacade->getLastPassedNewsreel($this->itemsInNewsreelMenuList);
		$this->template->render();
	}

	private function initCountOfItems()
	{
		$countOfItems = $this->optionFacade->getOptionValue('menu_newsreel_count');
		if((int) $countOfItems >= 1) $this->itemsInNewsreelMenuList = (int) $countOfItems;
	}
}
