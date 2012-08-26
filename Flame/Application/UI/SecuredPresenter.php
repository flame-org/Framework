<?php
/**
 * SecuredPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    26.08.12
 */

namespace Flame\Application\UI;

class SecuredPresenter extends Presenter
{

	/**
	 * @var string
	 */
	protected $loginLink = ':Front:Sign:in';

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		parent::checkRequirements($element);
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect($this->loginLink, array('backlink' => $this->getApplication()->storeRequest()));
		}
	}

	public function handleLogout()
	{
		$this->getUser()->logout(TRUE);
		$this->redirect($this->loginLink);
	}

}
