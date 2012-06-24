<?php

namespace AdminModule;

/**
* Comments managment
*/
class CommentPresenter extends AdminPresenter
{

	public function renderDefault()
	{
		if(!count($this->context->createComments()->getAll())){
			$this->flashMessage('Your visitors have not added any commnets yet');
		}
	}

	public function createComponentCommentList()
	{
		$comments = $this->context->createComments()->getAll();

		if(count($comments)){
			$posts = $this->context->createPosts();

			foreach ($comments as $key => $value) {
				$temp = $posts->getNameByID($value['id_post']);
				$comments[$key]['name'] = $temp[$value['id_post']];
			}
		}

		return new CommentList($comments);
	}
}
?>