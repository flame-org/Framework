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

	const STATUS_SUCCESS = 'success',
		STATUS_ERROR = 'error';

	/**
	 * @return mixed
	 */
	public function getPostData()
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
	 * @param int $code
	 */
	protected function returnException(\Exception $ex, $code = null)
	{
		Debugger::log($ex);

		if($code === null && $ex->getCode()){
			$code = $ex->getCode();
		}elseif($code === null){
			$code = 500;
		}

		$this->payload->status = self::STATUS_ERROR;
		$this->payload->message = $ex->getMessage();
		$this->payload->code = $code;

		$this->getHttpResponse()->setCode($code);

		$this->sendJson($this->getPayload());
	}


	/**
	 * @param array $data
	 * @param int $code
	 */
	protected function returnResponse(array $data = array(), $code = 200)
	{
		$this->payload->data = $data;
		$this->payload->code = $code;
		$this->payload->status = self::STATUS_SUCCESS;

		$this->getHttpResponse()->setCode($code);

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
				throw new ForbiddenRequestException('Bad method for this request. ' . $element->getDeclaringClass() . '::' . $element->getName());
		}else{
			if($element instanceof Method)
				throw new InvalidStateException('@method annotation is not set for method ' . $element->getDeclaringClass() . '::' . $element->getName());
		}
	}
}
