<?php
/**
 * Thumbnail
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Utils;

class Helpers extends \Nette\Object
{

	private $params;

	public function __construct(array $params = array())
	{
		$this->params = $params;
	}

	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return callback($this, $helper);
		}
	}

	public function markdown($text)
	{
		$markDown = new \dflydev\markdown\MarkdownExtraParser();
		return $markDown->transformMarkdown($text);
	}

	public function thumb($origName, $width, $height = NULL)
	{
		$thumb = new ThumbnailsCreator($this->params);
		return $thumb->thumb($origName, $width, $height);
	}


}
