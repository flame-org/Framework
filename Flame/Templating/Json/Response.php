<?php
/**
 * Response.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Sharezone
 *
 * @date    02.01.13
 */

namespace Flame\Templating\Json;

/**
 * @author    Pavel Kučera
 */
class Response extends \Nette\Object implements \Nette\Application\IResponse
{

	/** @var string */
	private $contentType;

	/** @var array */
	private $payload = array();

	/**
	 * @param string $contentType
	 */
	public function __construct($contentType = 'application/json')
	{
		$this->contentType = $contentType;
	}

	/**
	 * @return array
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/**
	 * @param array $payload
	 */
	public function setPayload(array $payload)
	{
		$this->payload = $payload;
	}

	/**
	 * @param string
	 * @param mixed
	 * @return JsonResponse
	 * @throws \Nette\InvalidStateException
	 */
	public function add($name, $value)
	{
		if (array_key_exists($name, $this->payload)) {
			throw new \Nette\InvalidStateException("A variable '$name' already exists.'");
		}
		return $this->set($name, $value);
	}

	/**
	 * @param $name
	 * @param $value
	 * @return Response
	 */
	public function set($name, $value)
	{
		$this->payload[$name] = $value;
		return $this;
	}

	/**
	 * @param string
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->payload[$name]);
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	public function &__get($name)
	{
		if (!array_key_exists($name, $this->payload)) {
			throw new \Nette\InvalidStateException("The variable '$name' does not exist.'");
		}
		return $this->payload[$name];
	}

	/**
	 * @param string
	 * @param mixed
	 * @return void
	 */
	public function __set($name, $value)
	{
		$this->set($name, $value);
	}

	/**
	 * @param string
	 * @return void
	 */
	public function __unset($name)
	{
		unset($this->payload[$name]);
	}

	/**
	 * @param \Nette\Http\IRequest
	 * @param \Nette\Http\IResponse
	 * @return void
	 */
	public function send(\Nette\Http\IRequest $httpRequest, \Nette\Http\IResponse $httpResponse)
	{
		$httpResponse->setContentType($this->contentType);
		$httpResponse->setExpiration(false);
		echo \Nette\Utils\Json::encode($this->payload);
	}

}
