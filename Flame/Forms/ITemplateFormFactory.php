<?php
/**
 * Class ITemplateFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */

namespace Flame\Forms;

use Nette\Localization\ITranslator;
use Nette\Forms\IFormRenderer;

interface ITemplateFormFactory
{

	/**
	 * Create base Form
	 *
	 * @return \Flame\Application\UI\TemplateForm
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
	 * Set form renderer
	 *
	 * @param IFormRenderer $renderer
	 * @return $this
	 */
	public function setRenderer(IFormRenderer $renderer = null);

	/**
	 * Set form processor
	 *
	 * @param IFormProcessor $processor
	 * @return $this
	 */
	public function setProcessor(IFormProcessor $processor = null);

	/**
	 * Set file template for Form
	 *
	 * @param string$path
	 * @return $this
	 */
	public function setTemplateFile($path);
}