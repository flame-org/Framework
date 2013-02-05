<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Application\UI;

use Flame\Utils\Strings;

abstract class RestPresenter extends JsonPresenter
{

	/**
	 * @var array
	 */
	protected $requestData;

	protected function startup()
	{

		parent::startup();

		$this->requestData = $this->getHttpRequest()->getPost();

		try {
			$this->checkMethodRequest();
		}catch (\Nette\InvalidStateException $ex) {
			$this->returnException($ex);
		}

	}
	/**
	 * @param \Exception $ex
	 * @return string
	 */
	protected function returnException(\Exception $ex)
	{
		\Nette\Diagnostics\Debugger::log($ex);
		$this->response->status = 'error';
		$this->response->message = $ex->getMessage();
		$this->sendResponse($this->getResponse());
	}

	/**
	 * @param $data
	 * @return string
	 */
	protected function returnResponse($data = array())
	{
		$this->response->status = 'success';
		$this->response->data = $data;
	}

	protected function checkMethodRequest()
	{
		$methodName = 'action' . Strings::firstUpper($this->action);
		$rc = $this->getReflection();
		if($rc->hasMethod($methodName) &&
			$method = $rc->getMethod($methodName)){

			if($method->hasAnnotation('method') &&
				$anot = $method->getAnnotation('method')){

				$reguest = $this->getHttpRequest();
				if(Strings::lower($anot) !== Strings::lower($reguest->getMethod())){
					throw new \Nette\InvalidStateException('Bad method for this request. ' . __CLASS__ . '::' . $methodName);
				}
			}
		}
	}

}
