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
		$this->template->setFile(__DIR__.'/PostList.latte');
		$this->template->posts = $this->posts;
		$this->template->render();
	}

}
?>