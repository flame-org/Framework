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

	private $steps;

	private $menu;

	private $position;


	public function addStep($linkName, $componentName)
	{
		$counter = count($this->menu) + 1;
		$this->menu[$counter] = $linkName;
		$this->steps[$counter] = $componentName;
	}


	protected function attached($obj)
	{
		parent::attached($obj);

		if ($obj instanceOf Presenter) {
			$this->position = $this->getPresenter()->getParameter('step') ? (int)$this->getPresenter()->getParameter('step') : 1;

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
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/StepFormControl.latte');

		$template->steps = $this->steps;
		$template->menu = $this->menu;
		$template->position = $this->position;

		$template->render();
	}

}