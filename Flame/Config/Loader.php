<?php
/**
 * Loader.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    13.01.13
 */

namespace Flame\Config;

use Nette;
use Nette\Utils\Validators;
use Nette\Config\Helpers;

class Loader extends \Nette\Config\Loader
{

	/** @var array */
	private $adapters = array(
		'php' => 'Nette\Config\Adapters\PhpAdapter',
		'ini' => 'Nette\Config\Adapters\IniAdapter',
		'neon' => 'Nette\Config\Adapters\NeonAdapter',
	);

	/** @var array */
	private $dependencies = array();

	/**
	 * @param $file
	 * @param null $section
	 * @return array
	 * @throws Nette\FileNotFoundException
	 */
	public function load($file, $section = null)
	{
		if (!is_file($file) || !is_readable($file)) {
			throw new Nette\FileNotFoundException("File '$file' is missing or is not readable.");
		}
		$this->dependencies[] = $file = realpath($file);
		$data = $this->getAdapter($file)->load($file);

		if ($section)
			$data = $this->getSection($data, $section, $file);

		// include child files
		$merged = array();
		if (isset($data[self::INCLUDES_KEY])) {
			Validators::assert($data[self::INCLUDES_KEY], 'list', "section 'includes' in file '$file'");
			foreach ($data[self::INCLUDES_KEY] as $include) {
				$merged = Helpers::merge($this->load(dirname($file) . '/' . $include), $merged);
			}
		}
		unset($data[self::INCLUDES_KEY]);

		return Helpers::merge($data, $merged);
	}

	/**
	 * @param $file
	 * @return \Nette\Config\IAdapter
	 * @throws \Nette\InvalidArgumentException
	 */
	private function getAdapter($file)
	{
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if (!isset($this->adapters[$extension])) {
			throw new Nette\InvalidArgumentException("Unknown file extension '$file'.");
		}
		return is_object($this->adapters[$extension]) ? $this->adapters[$extension] : new $this->adapters[$extension];
	}

	/**
	 * @param array $data
	 * @param $key
	 * @param $file
	 * @return array
	 */
	private function getSection(array $data, $key, $file)
	{
		Validators::assertField($data, $key, 'array|null', "section '%' in file '$file'");
		$item = $data[$key];
		if ($parent = Helpers::takeParent($item)) {
			$item = Helpers::merge($item, $this->getSection($data, $parent, $file));
		}
		return $item;
	}
}
