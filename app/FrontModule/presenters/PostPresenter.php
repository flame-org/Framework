<?php

namespace FrontModule;

/**
* Post presenter
*/
class PostPresenter extends FrontPresenter
{	
	private $post;

	public function actionDefault($id)
	{

		$this->post = $this->context->posts->find($id);

		if(!$this->post){
			$this->setView('notFound');
		}else{
			$this->context->posts->createOrUpdate(array('id' => $id, 'hit' => new \Nette\Database\SqlLiteral('hit +1')));
		}

		$this->template->post = $this->post;
	}

	protected function createComponentComments()
	{
		if(!$this->post) return null;

		$commentsControl = new Components\CommentsControl($this->context->comments);
		$commentsControl->setPostId($this->post->id);

		return $commentsControl;
	}
}
?>