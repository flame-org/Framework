<?php

/**
 * RSS control
 *
 * @author    Jan Marek
 * @license   MIT
 * @copyright (c) Jan Marek 2009
 *
 * @property string     $title
 * @property string     $description
 * @property string     $link
 * @property array      $items
 * @property-read array $properties
 */

namespace Flame\Addons\RssFeed;

use Nette\InvalidStateException;

class RssControl extends \Flame\Application\UI\Control
{

	/** @var array */
	private $properties;

	/** @var array */
	private $items;

	/**
	 * Render control
	 */
	public function beforeRender()
	{
		// properties
		$properties = $this->getProperties();
		$properties = $this->prepareProperties($properties);

		// check
		if (empty($properties["title"]) || empty($properties["description"]) || empty($properties["link"])) {
			throw new InvalidStateException("At least one of mandatory properties title, description or link was not set.");
		}

		// items
		$items = $this->getItems();
		foreach ($items as &$item) {
			$item = $this->prepareItem($item);

			// check
			if (empty($item["title"]) && empty($item["description"])) {
				throw new InvalidStateException("One of title or description has to be set.");
			}
		}

		// render template
		$this->template->channelProperties = $properties;
		$this->template->items = $items;
	}

	/**
	 * Convert date to RFC822
	 *
	 * @param string|date $date
	 * @return string
	 */
	public static function prepareDate($date)
	{
		if (is_string($date) && $date === (string)(int)$date) {
			$date = (int)$date;
		}

		if (is_string($date) && !String::endsWith($date, "GMT")) {
			$date = strtotime($date);
		}

		if (is_int($date)) {
			$date = gmdate('D, d M Y H:i:s', $date) . " GMT";
		}

		if ($date instanceof \DateTime) {
			$date = gmdate('D, d M Y H:i:s', $date->getTimestamp()) . " GMT";
		}

		return $date;
	}

	/**
	 * Prepare channel properties
	 *
	 * @return array
	 */
	public function prepareProperties($properties)
	{
		if (isset($properties["pubDate"])) {
			$properties["pubDate"] = self::prepareDate($properties["pubDate"]);
		}

		if (isset($properties["lastBuildDate"])) {
			$properties["lastBuildDate"] = self::prepareDate($properties["lastBuildDate"]);
		}

		return $properties;
	}

	/**
	 * Prepare item
	 *
	 * @return array
	 */
	public function prepareItem($item)
	{
		// guid & link
		if (empty($item["guid"]) && isset($item["link"])) {
			$item["guid"] = $item["link"];
		}

		if (empty($item["link"]) && isset($item["guid"])) {
			$item["link"] = $item["guid"];
		}

		// pubDate
		if (isset($item["pubDate"])) {
			$item["pubDate"] = self::prepareDate($item["pubDate"]);
		}

		return $item;
	}

	// getters & setters

	/**
	 * Set channel property
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public function setChannelProperty($name, $value)
	{
		$this->properties[$name] = $value;
	}

	/**
	 * Get channel property
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getChannelProperty($name)
	{
		return $this->properties[$name];
	}

	/**
	 * Get properties
	 *
	 * @return array
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->setChannelProperty("title", $title);
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getChannelProperty("title");
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->setChannelProperty("description", $description);
	}

	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->getChannelProperty("description");
	}

	/**
	 * Set link
	 *
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->setChannelProperty("link", $link);
	}

	/**
	 * Get link
	 *
	 * @return string
	 */
	public function getLink()
	{
		return $this->getChannelProperty("link");
	}

	/**
	 * Set items
	 *
	 * @param array $items
	 */
	public function setItems($items)
	{
		$this->items = $items;
	}

	/**
	 * Get items
	 *
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}
}