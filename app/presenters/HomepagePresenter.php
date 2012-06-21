<?php

/**
* Home page
*/
class HomepagePresenter extends BasePresenter
{
	
	public function renderDefault()
	{
		
	}

	public function createComponentPostList()
	{
		return new PostList($this->context->createPosts()->get());
	}
}

?>