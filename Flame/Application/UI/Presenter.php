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

use Nette\Application\ForbiddenRequestException;

/**
 * @property-read \Nette\Templating\Template $template
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 */
	public function checkRequirements($element)
	{
		try {
			parent::checkRequirements($element);
		} catch (ForbiddenRequestException $ex) {
			throw new ForbiddenRequestException('Access denied');
		}
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	public function getContextParameter($name, $default = null)
	{
		$params = $this->context->getParameters();

		return (isset($params[$name])) ? $params[$name] : $default;
	}

	/**
	 * @return mixed
	 */
	public function getBaseUrl()
	{
		return $this->getHttpRequest()->url->baseUrl;
	}

	/**
	 * @return bool
	 */
	public function isDebugMode()
	{
		return $this->getContextParameter('debugMode', false);
	}

}
