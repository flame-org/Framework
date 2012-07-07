<?php

namespace FrontModule\Components;

class NewsreelControl extends \Nette\Application\UI\Control
{
	private $newsreelFacade;

    private $itemsInNewsreelMenuList = 3;

	public function __construct(\Model\Newsreel\NewsreelFacade $newsreelFacade)
	{
		parent::__construct();
		$this->newsreelFacade = $newsreelFacade;
	}

    public function setCountOfItemsInNewsreel($count)
    {
        $this->itemsInNewsreelMenuList = (int) $count;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/NewsreelControl.latte');
		$this->template->newsreels = $this->newsreelFacade->getLastPassedNewsreel($this->itemsInNewsreelMenuList);
		$this->template->render();
	}
}