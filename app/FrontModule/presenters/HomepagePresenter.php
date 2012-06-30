<?php

namespace FrontModule;

/**
* Home page
*/
class HomepagePresenter extends FrontPresenter
{
	private $postsList;
	
	public function actionDefault()
	{
		$this->postsList = $this->context->createPosts()->getPublish();

		if(!count($this->postsList)){
			$this->flashMessage('No posts');
		}	
	}

	public function createComponentPostList()
	{
		$option = $this->context->createOptions()->getByName('items_per_page');

		if(!is_null($option)){
			return new PostList($this->postsList, $option);
		}else{
			return new PostList($this->postsList);
		}
	}
}

?>