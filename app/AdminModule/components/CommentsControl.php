<?php

namespace AdminModule;

use Nette\Application\UI;

/**
* Comments control
*/
class CommentsControl extends UI\Control
{
	private $service;
	private $comments;

	function __construct(\Nette\Database\Table\Selection $comments, \CommentsService $commentsService)
	{
		parent::__construct();
		$this->service = $commentsService;
		$this->comments = $comments;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/CommentsControl.latte');
		$this->template->comments = $this->comments;
		$this->template->render();
	}

	public function handleDelete($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Admin:Comment', 'delete')){
			$this->presenter->flashMessage('Access denided');
		}else{
			
			$row = $this->service->find($id);

			if($row){
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

			$row = $this->service->find($id);

			if($row){
				if((int)$row['publish'] == 1){
					$row = $this->service->createOrUpdate(array('id' => $id, 'publish' => '0'));
				}else{
					$row = $this->service->createOrUpdate(array('id' => $id, 'publish' => '1'));
				}
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