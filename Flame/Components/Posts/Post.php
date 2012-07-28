<?php

namespace Flame\Components\Posts;

/**
* Comments component
*/
class Post extends \Flame\Application\UI\Control
{

	private $itemsPerPage = 10;

	private $posts;

	public function __construct($posts)
	{
		parent::__construct();
		$this->posts = $posts;
	}

	public function setCountOfItemsPerPage($count)
	{
		if((int) $count >= 1) $this->itemsPerPage = (int) $count;
	}

	private function beforeRender()
	{
		$paginator = $this['paginator']->getPaginator();
		$paginator->itemCount = count($this->posts);

		$this->template->posts = $this->getItemsPerPage($this->posts, $paginator->offset);
	}

	public function render()
	{
		$this->beforeRender();
		$this->template->setFile(__DIR__ . '/PostFull.latte');
		$this->template->render();
	}

	public function renderExcept()
	{
		$this->beforeRender();
		$this->template->setFile(__DIR__ . '/PostExcept.latte');
		$this->template->render();
	}

	protected function createComponentPaginator()
	{
		$visualPaginator = new \Flame\Utils\VisualPaginator\Paginator($this, 'paginator');
	    $visualPaginator->paginator->itemsPerPage = $this->itemsPerPage;
	    return $visualPaginator;
	}

	private function getItemsPerPage(&$posts, $offset)
	{
		return array_slice($posts, $offset, $this->itemsPerPage);
	}

}
