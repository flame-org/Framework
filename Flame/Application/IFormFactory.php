<?php
/**
 * Class IFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Application;

use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;

interface IFormFactory
{

	/**
	 * Create base Form
	 *
	 * @return \Flame\Application\UI\Form
	 */
	public function createForm();

	/**
	 * Set translate adapter
	 *
	 * @param ITranslator $translator
	 * @return $this
	 */
	public function setTranslator(ITranslator $translator = null);


	/**
	 * Sets form renderer
	 *
	 * @param IFormRenderer $renderer
	 * @return $this
	 */
	public function setRenderer(IFormRenderer $renderer = null);

}