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

use Flame\Application\UI\Form;

abstract class Presenter extends \Nette\Application\UI\Presenter
{

	public function beforeRender()
	{
		parent::beforeRender();

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\ITemplate
	 */
	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(\Nette\Callback::create(new \Flame\Templating\Helpers, 'loader'));
		return $template;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	protected function getContextParameter($name, $default = null)
	{
		$params = $this->context->getParameters();
		if(isset($params[$name])) return $params[$name]; else return $default;
	}

	/**
	 * @return mixed
	 */
	protected function getBaseUrl()
	{
		return $this->getHttpRequest()->url->baseUrl;
	}

}
