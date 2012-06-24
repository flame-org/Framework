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
	
	function __construct(Selection $comments)
	{
		parent::__construct();
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
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->presenter->context->createComments()->where(array('id' => $id))->fetch();
			if($row !== false)
				$row->delete();

			$this->redirect('this');
		}
	}

	public function handlePublish($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Admin:Comment', 'publish')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->presenter->context->createComments()->where(array('id' => $id))->update(array('publish' => '1'));

			$this->redirect('this');
		}
	}

	public function handleUnPublish($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Admin:Comment', 'publish')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->presenter->context->createComments()->where(array('id' => $id))->update(array('publish' => '0'));

			$this->redirect('this');
		}
	}
}

?>