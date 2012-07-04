<?php

namespace FrontModule;

/**
* Home page
*/
class HomepagePresenter extends FrontPresenter
{
	private $posts;
	
	public function actionDefault()
	{
		$this->posts = $this->context->posts;

		if(!count($this->posts->findBy(array('publish' => '1')))){
			$this->flashMessage('No posts');
		}	
	}

	public function createComponentPostControl()
	{
		$postControl = new PostControl($this->posts);

		$itemsPerPage = $this->context->options->getOptionValue('items_per_page');
		if($itemsPerPage){
			$postControl->setItemsPerPage($itemsPerPage);
		}

		return $postControl;
	}
}

?>