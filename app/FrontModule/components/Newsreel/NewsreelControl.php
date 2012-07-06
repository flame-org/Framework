<?php

namespace FrontModule\Components;

class NewsreelControl extends \Nette\Application\UI\Control
{
	private $newsreelFacade;

	public function __construct(\Model\Newsreel\NewsreelFacade $newsreelFacade)
	{
		parent::__construct();
		$this->newsreelFacade = $newsreelFacade;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/NewsreelControl.latte');
		$this->template->newsreels = $this->newsreelFacade->getLastNewsreel();
		$this->template->render();
	}
}