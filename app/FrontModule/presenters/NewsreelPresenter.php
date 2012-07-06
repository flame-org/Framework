<?php

namespace FrontModule;

class NewsreelPresenter extends FrontPresenter
{

	private $newsreelFacade;

	public function __construct(\Model\Newsreel\NewsreelFacade $newsreelFacade)
	{
		$this->newsreelFacade = $newsreelFacade;
	}
	
	public function actionDetail($id)
	{
		if($newsreel = $this->newsreelFacade->getOne($id)){
			$this->newsreelFacade->increaseHit($newsreel);
			$this->template->newsreel = $newsreel;
		}else{
			$this->flashMessage('The Newsreel does not exist!');
		}
	}
}