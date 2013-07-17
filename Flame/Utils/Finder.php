<?php
/**
 * Class Finder
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 09.07.13
 */
namespace Flame\Utils;

class Finder extends \Nette\Utils\Finder
{

	/** @var  \Closure */
	private $order;

	/**
	 * Sets the order comparison function
	 * @param callback $order
	 * @return Finder
	 */
	public function order(\Closure $order)
	{
		$this->order = $order;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function orderByName()
	{
		$this->order = function($f1, $f2) {
			return strcasecmp($f1->getFilename(), $f2->getFilename());
		};
		return $this;
	}

	/**
	 * @return $this
	 */
	public function orderByMTime()
	{
		$this->order = function($f1, $f2) {
			return $f1->getMTime() < $f2->getMTime();
		};
		return $this;
	}


	/**
	 * Returns iterator.
	 * @return \Iterator
	 */
	public function getIterator()
	{
		$iterator = parent::getIterator();
		if ($this->order === NULL) {
			return $iterator;
		}

		$iterator = new \ArrayIterator(iterator_to_array($iterator));
		$iterator->uasort($this->order);

		return $iterator;
	}

}