<?php

namespace FrontModule;

class NewsreelPresenter extends FrontPresenter
{

	private $newsreelFacade;

	public function __construct(\Flame\Models\Newsreel\NewsreelFacade $newsreelFacade)
	{
		$this->newsreelFacade = $newsreelFacade;
	}
	
	public function actionDetail($id)
	{
		if($newsreel = $this->newsreelFacade->getOne($id)){
            $newsreel->setHit($newsreel->getHit() + 1);
			$this->newsreelFacade->persist($newsreel);
			$this->template->newsreel = $newsreel;
		}else{
			$this->setView('notFound');
		}
	}
}