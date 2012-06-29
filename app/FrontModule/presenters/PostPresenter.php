<?php

namespace FrontModule;

/**
* Post presenter
*/
class PostPresenter extends FrontPresenter
{

	public $postID;

	public function actionDefault($id)
	{
		$this->postID = $id;
		$posts = $this->context->createPosts();

		$post = $posts->getDetail($id);

		if($post === false){
			$this->setView('notFound');
		}else{
			$posts->updateHit($id);
			$this->template->post = $post;
		}
	}

	protected function createComponentComments()
	{
		$comments = $this->context->createComments()->get($this->postID);
		return new Comments($comments);
	}
}
?>