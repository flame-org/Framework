<?php
/**
 * Loader.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    13.01.13
 */

namespace Flame\Config;

use Nette;

class Loader extends \Nette\Config\Loader
{

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

}
