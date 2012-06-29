<?php

namespace AdminModule;

use Nette\Application\UI, 
	Nette\Database\Table\Selection;

/**
* 
*/
class CommentList extends UI\Control
{
	private $comments;
	private $commentsFactory;
	private $postsFactory;

	function __construct(Selection $comments, \Model\Comments $commentsFactory)
	{
		parent::__construct();

		$this->commentsFactory = $commentsFactory;
		$this->comments = $comments;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/CommentList.latte');
		$this->template->comments = $this->comments;
		$this->template->render();
	}

	public function handleDelete($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Admin:Comment', 'delete')){
			$this->presenter->flashMessage('Access denided');
		}else{
			$row = $this->commentsFactory->where(array('id' => $id))->fetch();
			if($row !== false){
				$row->delete();
			}else{
				$this->presenter->flashMessage('The comment with required ID does not exist.');
			}
		}

		if(!$this->presenter->isAjax()){
			$this->presenter->redirect('this');
		}else{
			$this->invalidateControl();
		}
	}

	public function handleMarkPublish($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Admin:Comment', 'publish')){
			$this->presenter->flashMessage('Access denided');
		}else{

			$row = $this->commentsFactory->where(array('id' => $id))->fetch();

			if((int)$row['publish'] == 1){
				$row = $this->commentsFactory->where(array('id' => $id))->update(array('publish' => '0'));
			}else{
				$row = $this->commentsFactory->where(array('id' => $id))->update(array('publish' => '1'));
			}
		}

		if(!$this->presenter->isAjax()){
			$this->presenter->redirect('this');
		}else{
			$this->invalidateControl();
		}
	}
}

?>