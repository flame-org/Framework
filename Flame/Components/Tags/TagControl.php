<?php
/**
 * TagControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    28.07.12
 */

namespace Flame\Components;

class TagControl extends \Flame\Application\UI\Control
{

	private $tagFacade;

	public function __construct(\Flame\Models\Tags\TagFacade $tagFacade)
	{
		parent::__construct();
		$this->tagFacade = $tagFacade;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/TagControl.latte');
		$this->template->tags = $this->tagFacade->getLastTags();
		$this->template->render();
	}

}
