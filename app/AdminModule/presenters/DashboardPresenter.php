<?php

namespace AdminModule;

/**
* Dashboard for administration
*/
class DashboardPresenter extends AdminPresenter
{

	private $commentsFactory;

	public function actionDefault()
	{
		$this->commentsFactory = $this->context->createComments();
		$this->template->unPublishComments = count($this->commentsFactory->getUnPublish());
	}	

	public function createComponentCommentList()
	{
		return new CommentList($this->commentsFactory->getUnPublish(), $this->context->createComments());
	}

}
?>