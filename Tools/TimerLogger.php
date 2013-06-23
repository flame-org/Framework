<?php
/**
 * Class TimerLogger
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.06.13
 */

use \Flame\Tools\Files\FileSystem;

class TimerLogger
{
	const FILE = './timer.txt';

	/**
	 * @return mixed
	 */
	static public function getCache()
	{
		$content = FileSystem::read(static::FILE, false);

		if(!$content) {
			static::write(array());
			return array();
		}

		return json_decode($content);
	}

	/**
	 * @return int
	 */
	static public function clearCache()
	{
		return static::write(array());
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	static function getCacheBy($name)
	{
		$cache = (array) static::getCache();
		if(isset($cache[$name])) {
			return $cache[$name];
		}
	}

	/**
	 * @param $name
	 * @param $value
	 * @return int
	 */
	static public function writeToCache($name, $value)
	{
		$cache = (array) static::getCache();

		if(!isset($cache[$name]) || !is_array($cache[$name])) {
			$cache[$name] = array();
		}

		$cache[$name][] = $value;

		return static::write($cache);
	}

	/**
	 * @param $value
	 * @return int
	 */
	static private function write($value)
	{
		return FileSystem::write(static::FILE, json_encode($value));
	}

}