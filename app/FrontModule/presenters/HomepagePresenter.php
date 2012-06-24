<?php

namespace FrontModule;

/**
* Home page
*/
class HomepagePresenter extends FrontPresenter
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