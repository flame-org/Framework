<?php
/**
 * Redirect.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    17.04.13
 */

namespace Flame\Application\UI;

use Nette\Application\UI;

class Redirect extends UI\Link
{

	/** @var UI\PresenterComponent */
	private $component;

	public function __construct(UI\PresenterComponent $component, $destination, array $params)
	{
		parent::__construct($component, $destination, $params);
		$this->component = $component;
	}

	public function __invoke()
	{
		$this->component->redirect($this->getDestination(), $this->getParameters());
	}

}
