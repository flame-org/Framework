<?php

namespace AdminModule;

/**
* Comments managment
*/
class CommentPresenter extends AdminPresenter
{
	private $service;

	public function actionDefault()
	{
		$this->service = $this->context->comments;
	}

	public function createComponentCommentsControl()
	{
		return new Componnets\CommentsControl($this->service->findAll(), $this->service);
	}
}
?>