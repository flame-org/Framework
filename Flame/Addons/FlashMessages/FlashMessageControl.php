<?php
/**
 * FlashMessageControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    26.01.13
 */

namespace Flame\Addons\FlashMessages;

use Flame\Application\UI\Control;

class FlashMessageControl extends Control
{

	/** @var string  */
	private $templateFile;

	/**
	 * @param null $templateFile
	 */
	public function __construct($templateFile = null)
	{
		parent::__construct();

		if (!$templateFile) {
			 $templateFile = __DIR__ . '/FlashMessageControl.latte';
		}

		$this->templateFile = $templateFile;
	}

	public function render()
	{
		$this->template->flashes = $this->parent->template->flashes;
		$this->template->setFile($this->templateFile)->render();
	}

}
