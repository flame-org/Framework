<?php
/**
 * FlashMessageControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    26.01.13
 */

namespace Flame\Addons\FlashMessages;

class FlashMessageControl extends \Flame\Application\UI\Control
{

	/**
	 * @var string
	 */
	private $templateFile;

	/**
	 * @param null $templateFile
	 */
	public function __construct($templateFile = null)
	{
		parent::__construct();

		$this->templateFile = $templateFile;

		if(!$templateFile)
			$this->templateFile = __DIR__ . '/FlashMessageControl.latte';
	}

	public function renderDefault()
	{
		$this->template->flashes = $this->parent->getTemplate()->flashes;
		$this->template->setFile($this->templateFile)->render();
		$this->template->render();
	}

}
