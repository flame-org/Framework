<?php

namespace FrontModule;

/**
* Display special message pages
*/
class MessagePresenter extends FrontPresenter
{
	
	public function actionAccessDenied()
	{
		$this->flashMessage('Access Denied');
	}
}
?>