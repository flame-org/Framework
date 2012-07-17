<?php

namespace Flame\Components;

/**
* Comments component
*/
class PostsControl extends \Flame\Application\UI\Control
{

	private $itemsPerPage = 2;

	private $posts;

	public function __construct($posts)
	{
		$this->posts = $posts;
	}

	public function setCountOfItemsPerPage($count)
	{
		$this->itemsPerPage = $count;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/PostsControlFull.latte');

		$paginator = $this['paginator']->getPaginator();
		$paginator->itemCount = count($this->posts);

		$this->template->posts = $this->getItemsPerPage($this->posts, $paginator->offset);
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

	private function getItemsPerPage(&$posts, $offset)
	{
		return array_slice($posts, $offset, $this->itemsPerPage);
	}

}
?>