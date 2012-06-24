<?php

use Nette\Application\UI, Nette\Database\Table\Selection;

/**
* Comments component
*/
class PostList extends UI\Control
{
	private $posts;

	public function __construct(Selection $posts)
	{
		parent::__construct();
		$this->posts = $posts;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/PostListExcept.latte');
		$this->template->posts = $this->posts;
		$this->template->render();
	}

	public function renderFull()
	{
		$this->template->setFile(__DIR__.'/PostListFull.latte');
		$this->template->posts = $this->posts;
		$this->template->render();
	}

	public function handleDelete($id)
	{
		if(!$this->presenter->getUser()->isAllowed('Post', 'delete')){
			$this->redirect('Message:accessDenied');
		}else{
			$row = $this->posts->where(array('id' => $id))->fetch();
			if($row !== false)
				$row->delete();

			$this->redirect('this');
		}
	}

}
?>