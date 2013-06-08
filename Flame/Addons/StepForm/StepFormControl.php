<?php
/**
 * StepFormControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    08.11.12
 */

namespace Flame\Addons\StepForm;

use Nette\Application\UI\Control;
use Nette\Application\UI\IRenderable;
use Nette\Application\UI\Presenter;

/**
 * @author 22 <http://forum.nette.org/cs/profile.php?id=2651>
 */
class StepFormControl extends Control
{

	/** @var array  */
	private $steps = array();

	/** @var array  */
	private $menu = array();

	/** @var  int */
	private $position;

	/**
	 * @param $linkName
	 * @param $componentName
	 */
	public function addStep($linkName, $componentName)
	{
		$counter = count($this->menu) + 1;
		$this->menu[$counter] = $linkName;
		$this->steps[$counter] = $componentName;
	}

	/**
	 * @param $obj
	 */
	protected function attached($obj)
	{
		parent::attached($obj);

		if ($obj instanceOf Presenter) {
			$this->position = $this->getPresenter()->getParameter('step') ? (int)$this->getPresenter()->getParameter('step') : 1;

			$steps = array();

			if (count($this->steps)) {
				foreach ($this->steps as $key => $step) {
					$steps[$key] = $step;
				}

				$this->steps = $steps;
			}
		}
	}


	public function render()
	{
		$this->template->setFile(__DIR__ . '/StepFormControl.latte');

		$this->template->steps = $this->steps;
		$this->template->menu = $this->menu;
		$this->template->position = $this->position;

		$this->template->render();
	}

}