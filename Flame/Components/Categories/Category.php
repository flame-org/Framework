<?php
/**
 * CategoriesControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    16.07.12
 */

namespace Flame\Components\Categories;

class Category extends \Flame\Application\UI\Control
{

	/**
	 * @var \Flame\Models\Categories\CategoryFacade
	 */
	private $categoryFacade;

	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct($parent, $name)
	{
		parent::__construct($parent, $name);

		$this->categoryFacade = $this->presenter->context->CategoryFacade;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/Category.latte');
		$this->template->categories = $this->categoryFacade->getLastCategories();
		$this->template->render();
	}

}
