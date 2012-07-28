<?php
/**
 * CategoriesControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    16.07.12
 */

namespace Flame\Components;

class CategoriesControl extends \Flame\Application\UI\Control
{

	private $categoryFacade;

	public function __construct(\Flame\Models\Categories\CategoryFacade $categoryFacade)
	{
		$this->categoryFacade = $categoryFacade;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/CategoriesControl.latte');
		$this->template->categories = $this->categoryFacade->getLastCategories();
		$this->template->render();
	}

}
