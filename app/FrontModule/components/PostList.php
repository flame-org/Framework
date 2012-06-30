<?php

namespace FrontModule;

use Nette\Application\UI, 
	Nette\Database\Table\Selection;

/**
* Comments component
*/
class PostList extends UI\Control
{
	private $posts;
	private $itemsPerPage;

	public function __construct(Selection $posts, $itemsPerPage = 10)
	{
		parent::__construct();
		$this->posts = $posts;
		$this->itemsPerPage = $itemsPerPage;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/PostListFull.latte');

		$paginator = $this['paginator']->getPaginator();
		$paginator->itemCount = count($this->posts);

		$this->posts->limit($paginator->itemsPerPage, $paginator->offset);

		$this->template->posts = $this->posts;
		$this->template->render();
	}

	public function renderExcept()
	{
		
	}

	protected function createComponentPaginator()
	{
		$visualPaginator = new \VisualPaginator($this, 'paginator');
	    $visualPaginator->paginator->itemsPerPage = $this->itemsPerPage;
	    return $visualPaginator;	
	}

}
?>