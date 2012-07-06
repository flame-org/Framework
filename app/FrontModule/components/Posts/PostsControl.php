<?php

namespace FrontModule\Componnets;

use Nette\Application\UI;

/**
* Comments component
*/
class PostsControl extends UI\Control
{
	private $service;
	private $itemsPerPage = 10;

	public function __construct(\PostsService $postsService)
	{
		$this->service = $postsService;
	}

	public function setItemsPerPage($count)
	{
		$this->itemsPerPage = $count;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/PostsControlFull.latte');

		$paginator = $this['paginator']->getPaginator();

		$posts = $this->service->findBy(array('publish' => '1'));
		$paginator->itemCount = count($posts);

		$posts->limit($paginator->itemsPerPage, $paginator->offset);

		$this->template->posts = $posts;
		$this->template->render();
	}

	public function renderExcept()
	{
		
	}

	protected function createComponentPaginator()
	{
		$visualPaginator = new \Utils\VisualPaginator($this, 'paginator');
	    $visualPaginator->paginator->itemsPerPage = $this->itemsPerPage;
	    return $visualPaginator;	
	}

}
?>