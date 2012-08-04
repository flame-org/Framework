<?php

namespace Flame\Components\Posts;

/**
* Comments component
*/
class Post extends \Flame\Application\UI\Control
{
	private $posts;

	private $optionFacade;

	private $itemsPerPage = 10;

	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct($parent, $name)
	{
		parent::__construct($parent, $name);
		$this->optionFacade = $this->presenter->context->OptionFacade;
	}

	/**
	 * @param $posts
	 */
	public function setPosts($posts)
	{
		$this->posts = $posts;
	}

	private function initItemsPerPage()
	{
		$itemsPerPage = $this->optionFacade->getOptionValue('items_per_page');
		if((int) $itemsPerPage >= 1) $this->itemsPerPage = (int) $itemsPerPage;
	}

	/**
	 * @throws \Nette\InvalidArgumentException
	 */
	private function beforeRender()
	{
		if(is_null($this->posts)){
			throw new \Nette\InvalidArgumentException('You must set posts');
		}

		$this->initItemsPerPage();

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

	/**
	 * @return \Flame\Utils\VisualPaginator\Paginator
	 */
	protected function createComponentPaginator()
	{
		$visualPaginator = new \Flame\Utils\VisualPaginator\Paginator($this, 'paginator');
	    $visualPaginator->paginator->itemsPerPage = $this->itemsPerPage;
	    return $visualPaginator;
	}

	/**
	 * @param $posts
	 * @param $offset
	 * @return array
	 */
	private function getItemsPerPage(&$posts, $offset)
	{
		return array_slice($posts, $offset, $this->itemsPerPage);
	}

}
