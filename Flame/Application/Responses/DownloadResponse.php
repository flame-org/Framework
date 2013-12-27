<?php
/**
 * Class DownloadResponse
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 27.12.13
 */
namespace Flame\Application\Responses;

use Nette\Application\IResponse;
use Nette\Object;
use Nette;

class DownloadResponse extends Object implements IResponse
{

	/** @var  string */
	private $content;

	/** @var  string */
	private $name;

	/** @var null|string  */
	private $contentType;

	/**
	 * @param $content
	 * @param $name
	 * @param null $contentType
	 */
	function __construct($content, $name, $contentType = null)
	{
		$this->content = (string) $content;
		$this->name = (string) $name;
		$this->contentType = $contentType ? $contentType : 'application/octet-stream';
	}

	/**
	 * Returns the content of downloaded file.
	 *
	 * @return string
	 */
	final public function getContent()
	{
		return $this->content;
	}

	/**
	 * Returns the file name.
	 *
	 * @return string
	 */
	final public function getName()
	{
		return $this->name;
	}

	/**
	 * Returns the MIME content type of an downloaded file.
	 *
	 * @return string
	 */
	final public function getContentType()
	{
		return $this->contentType;
	}

	/**
	 * @param Nette\Http\IRequest $httpRequest
	 * @param Nette\Http\IResponse $httpResponse
	 */
	function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
	{
		$httpResponse->setContentType($this->contentType);
		$httpResponse->setHeader('Pragma', "public");
		$httpResponse->setHeader('Expires', 0);
		$httpResponse->setHeader('Cache-Control', "must-revalidate, post-check=0, pre-check=0");
		$httpResponse->setHeader('Content-Transfer-Encoding', "binary");
		$httpResponse->setHeader('Content-Description', "File Transfer");
		$httpResponse->setHeader('Content-Length', mb_strlen($this->content));
		$httpResponse->setHeader('Content-Disposition', 'attachment; filename="' . $this->name . '"');
		echo $this->content;
	}
}