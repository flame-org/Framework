<?php
/**
 * UIFormTestingPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.11.12
 */

namespace Flame\Tests\Tools;

class UIFormTestingPresenter extends \Flame\Application\UI\Presenter
{

	/** @var \Nette\Application\UI\Form */
	private $form;

	/**
	 * @param \Flame\Application\UI\Form $form
	 */
	public function __construct(\Flame\Application\UI\Form $form)
	{
		parent::__construct();
		$this->form = $form;
	}

	/**
	 * Just terminate the rendering
	 */
	public function renderDefault()
	{
		$this->terminate();
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentForm()
	{
		return $this->form;
	}

}
