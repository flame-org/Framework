<?php
/**
 * Presenter
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

use Nette\Forms\Rules,
	Flame\Application\UI\Form;

abstract class Presenter extends \Nette\Application\UI\Presenter
{
	public function startup()
	{
		parent::startup();
		$this->setDefaultsFormMessages();
	}

	public function beforeRender()
	{
		parent::beforeRender();

		$this->template->name = $this->context->OptionFacade->getOptionValue('name');

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}

	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(
			$this->context->Helpers,
			'loader'
		));
		return $template;
	}

	private function setDefaultsFormMessages()
	{
		Rules::$defaultMessages = array(
			Form::EQUAL => 'Please enter %s.',
			Form::FILLED => 'Field "%label" is required.',
			Form::MIN_LENGTH => 'Field "%label" must be longer than %d chars.',
			Form::MAX_LENGTH => 'Field "%label" must be shorter than %d chars.',
			Form::LENGTH => 'Value of field "%label" must be longer than %d and shorter than %d chars.',
			Form::EMAIL => 'Field "%label" must be valid email address.',
			Form::URL => 'Field "%label" must be valid URL address.',
			Form::IMAGE => 'You can upload only JPEG, GIF or PNG files.'
		);
	}
}
