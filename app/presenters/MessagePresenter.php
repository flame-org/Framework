<?php

/**
* Display special message pages
*/
class MessagePresenter extends BasePresenter
{
	
	public function actionAccessDenied()
	{
		$this->flashMessage('Access Denied');
	}
}
?>