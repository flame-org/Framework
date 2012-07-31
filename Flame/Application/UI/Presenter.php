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

		$this->template->jqueryLib = $this->getJQueryLib();

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
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

	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(new \Flame\Utils\Helpers($this->getContextParameter('imageStorage')), 'loader'));
		return $template;
	}

	protected function getContextParameter($name = null)
	{
		$params = $this->context->getParameters();
		if(isset($params[$name])) return $params[$name]; else return null;
	}

	protected function getBaseUrl()
	{
		return $this->getHttpRequest()->url->baseUrl;
	}

	private function getJQueryLib()
	{
		$local = $this->getBaseUrl() . 'js/jquery-1.7.2.min.js';
		$googleApis = 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';
		if(@file($googleApis)){
			return $googleApis;
		}

		return $local;
	}

}
