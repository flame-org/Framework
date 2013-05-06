<?php
/**
 * AntiSpamControl.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.11.12
 */

namespace Flame\Forms\Controls;

use Nette\Utils\Html;

class AntiSpamControl extends \Nette\Forms\Controls\HiddenField
{

	public function getControl()
	{
		if (empty($this->value))
			$this->value = 'nospam';

		$hiddenControl = parent::getControl();

		$this->control->type = 'text';
		$this->value = '';
		$this->setAttribute('class', 'text');
		$this->setAttribute('placeholder', 'Put text "' . $this->value . '" into the field.');
		$control = parent::getControl();

		$control = $this->addAntispamScript($control, $hiddenControl);

		return $control;
	}

	/**
	 * @param \Nette\Utils\Html $control
	 * @param \Nette\Utils\Html $hiddenControl
	 * @return \Nette\Utils\Html
	 */
	protected function addAntispamScript(Html $control, Html $hiddenControl)
	{
		$control = Html::el('')->add($control);

		$control->setHtml(
			Html::el('noscript')->setHtml($control) .
				Html::el('script', array('type' => 'text/javascript'))->setHtml("
				document.write('" . $hiddenControl . "');
			")
		);

		return $control;
	}

}
