<?php

namespace AdminModule;

/**
* Dashboard for administration
*/
class DashboardPresenter extends AdminPresenter
{
	public function renderDefault()
	{
		$this->template->unPublishComments = count($this->context->createComments()->getUnPublish());
	}	

	public function createComponentCommentList()
	{
		return new CommentList($this->context->createComments()->getUnPublish());
	}

}
?>