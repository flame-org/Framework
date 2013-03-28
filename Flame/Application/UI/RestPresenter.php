<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Application\UI;

use Flame\Utils\Strings;

abstract class RestPresenter extends Presenter
{

	/** @var array */
	protected $requestData;

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{

		try {
			parent::checkRequirements($element);
			$this->checkMethodRequest($element);

		}catch (\Nette\Application\ForbiddenRequestException $ex) {
			$this->returnException($ex);
		}
	}

	protected function startup()
	{
		parent::startup();

		$this->requestData = $this->getHttpRequest()->getPost();

		$this->payload->status = 'success';
	}

	/**
	 * @param \Exception $ex
	 * @return string
	 */
	protected function returnException(\Exception $ex)
	{
		\Nette\Diagnostics\Debugger::log($ex);
		$this->payload->status = 'error';
		$this->payload->message = $ex->getMessage();
		$this->returnResponse();
	}


	/**
	 * @param array $data
	 */
	protected function returnResponse(array $data = array())
	{
		$this->payload->data = $data;
		$this->sendJson($this->getPayload());
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 */
	protected function checkMethodRequest($element)
	{
		if($anot = $element->getAnnotation('method')){
			$reguest = $this->getHttpRequest();
			if(Strings::lower($anot) !== Strings::lower($reguest->getMethod())){
				throw new \Nette\Application\ForbiddenRequestException('Bad method for this request. ' . __CLASS__ . '::' . $element->getName());
			}
		}
	}
}
