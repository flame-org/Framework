<?php
/**
 * Class ITemplateFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */

namespace Flame\Forms;


use Flame\Forms\IFormFactory;

interface ITemplateFormFactory extends IFormFactory
{

	/**
	 * Create base Form
	 *
	 * @return \Flame\Application\UI\TemplateForm
	 */
	public function createForm();

	/**
	 * Set file template for Form
	 *
	 * @param string$path
	 * @return $this
	 */
	public function setTemplateFile($path);
}