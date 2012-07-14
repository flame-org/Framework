<?php

namespace Flame\Components;

/**
* Comments component
*/
class PostsControl extends \Flame\Application\UI\Control
{
	private $postFacade;
	private $itemsPerPage = 10;

	public function __construct(\Flame\Models\Posts\PostFacade $postFacade)
	{
		$this->postFacade = $postFacade;
	}

	public function setItemsPerPage($count)
	{
		$this->itemsPerPage = $count;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/PostsControlFull.latte');

		$paginator = $this['paginator']->getPaginator();

		$posts = $this->postFacade->getLastPublishPosts();
		$paginator->itemCount = count($posts);

		//$posts->limit($paginator->itemsPerPage, $paginator->offset);

		$this->template->posts = $posts;
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