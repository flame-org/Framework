<?php
/**
 * JsonPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.01.13
 */

namespace Flame\Application\UI;

/**
 * @author  Pavel Kučera
 * @property Response $response
 */
abstract class JsonPresenter extends Presenter
{

	/** @var bool */
	protected $compileVariables = false;

	/** @var \Flame\Templating\Json\Response */
	private $response;

	/**
	 * @return \Flame\Templating\Json\Response
	 */
	protected function createResponse()
	{
		return new \Flame\Templating\Json\Response($this->compileVariables);
	}

	/**
	 * @return \Flame\Templating\Json\Response
	 */
	public function getResponse()
	{
		if (!$this->response)
			$this->response = $this->createResponse();
		
		return $this->response;
	}

	/**
	 * @param string
	 * @return void
	 * @throws \Nette\InvalidStateException
	 */
	protected function createTemplate($class = null)
	{
		throw new \Nette\InvalidStateException("Json presenter does not support access to \$template use \$response instead.");
	}

	public function sendTemplate()
	{
		$this->sendResponse($this->getResponse());
	}
}
