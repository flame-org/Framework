<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Application\UI;

use Flame\Utils\Strings;
use Nette\Application\ForbiddenRequestException;
use Nette\Diagnostics\Debugger;
use Nette\InvalidStateException;
use Nette\Reflection\Method;

abstract class RestPresenter extends Presenter
{

	/**
	 * @return mixed
	 */
	public function getRequestData()
	{
		return $this->getHttpRequest()->getPost();
	}

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{

		try {
			parent::checkRequirements($element);
			$this->checkMethodRequest($element);

		} catch (ForbiddenRequestException $ex) {
			$this->returnException($ex);
		}
	}

	/**
	 * @param \Exception $ex
	 * @return string
	 */
	protected function returnException(\Exception $ex)
	{
		Debugger::log($ex);
		$this->payload->status = 'error';
		$this->payload->message = $ex->getMessage();
		$this->sendJson($this->getPayload());
	}


	/**
	 * @param array $data
	 */
	protected function returnResponse(array $data = array())
	{
		$this->payload->data = $data;
		$this->payload->status = 'success';
		$this->sendJson($this->getPayload());
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 * @throws \Nette\InvalidStateException
	 */
	protected function checkMethodRequest($element)
	{
		if ($anot = $element->getAnnotation('method')) {
			$reguest = $this->getHttpRequest();
			if (Strings::lower($anot) !== Strings::lower($reguest->getMethod()))
				throw new ForbiddenRequestException('Bad method for this request. ' . __CLASS__ . '::' . $element->getName());
		}else{
			if($element instanceof Method)
				throw new InvalidStateException('@method annotation is not set for method ' . __CLASS__ . '::' . $element->getName());
		}
	}
}
