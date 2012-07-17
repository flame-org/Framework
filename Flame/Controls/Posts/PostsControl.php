<?php

namespace Flame\Components;

/**
* Comments component
*/
class PostsControl extends \Flame\Application\UI\Control
{

	private $itemsPerPage = 10;

	private $posts;

	public function __construct($posts)
	{
		$this->posts = $posts;
	}

	public function setItemsPerPage($count)
	{
		$this->itemsPerPage = $count;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/PostsControlFull.latte');

		$paginator = $this['paginator']->getPaginator();
		$paginator->itemCount = count($this->posts);

		//$posts->limit($paginator->itemsPerPage, $paginator->offset);

		$this->template->posts = $this->posts;
		$this->template->render();
	}

	public function renderExcept()
	{
		
	}

	protected function createComponentPaginator()
	{
		$visualPaginator = new \Flame\Utils\VisualPaginator($this, 'paginator');
	    $visualPaginator->paginator->itemsPerPage = $this->itemsPerPage;
	    return $visualPaginator;	
	}

}
?>