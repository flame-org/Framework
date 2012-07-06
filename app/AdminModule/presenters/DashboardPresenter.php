<?php

namespace AdminModule;

/**
* Dashboard for administration
*/
class DashboardPresenter extends AdminPresenter
{

	private $service;
	private $unPublishComments;

	public function actionDefault()
	{
		$this->service = $this->context->comments;
		$this->unPublishComments = $this->service->findBy(array('publish' => '0'));
		$this->template->unPublishComments = $this->unPublishComments;
	}	

	protected function createComponentCommentsControl()
	{
		if(!$this->unPublishComments){
			return null;
		}else{
			return new Components\CommentsControl($this->unPublishComments, $this->service);
		}
	}

}
?>