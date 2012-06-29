<?php

namespace AdminModule;

/**
* Comments managment
*/
class CommentPresenter extends AdminPresenter
{
	private $comments;

	public function actionDefault()
	{
		$this->comments = $this->context->createComments();
	}

	public function createComponentCommentList()
	{
		$comments = $this->comments->getAll();

		return new CommentList($comments, $this->context->createComments());
	}
}
?>