<?php
/**
 * Class Timer
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.06.13
 */


use Nette\Diagnostics\Debugger;

class Timer
{
	const CACHE_KEY = 'timer';

	static $timers;

	static $dump = true;

	/**
	 * @param $name
	 * @return float
	 */
	static public function d($name)
	{
		if(isset(static::$timers[$name])) {

			 $result = Debugger::timer($name) * 1000;

			if(static::$dump === true) {
				Debugger::barDump($result . ' ms', $name);
			}

			\TimerLogger::writeToCache($name, $result);
		}else{
			static::$timers[$name] = $name;
			$result = Debugger::timer($name);
		}
		
		return $result;
	}

	static public function clearCache()
	{
		\TimerLogger::clearCache();
	}

	/**
	 * @param $name
	 * @return float|int
	 */
	static public function getAverageFor($name)
	{
		$values = \TimerLogger::getCacheBy($name);
		$sum = 0;
		$average = 0;
		if(count($values)) {
			foreach($values as $value) {
				$sum += $value;
			}

			$average = $sum / count($values);
		}

		if(static::$dump === true) {
			Debugger::barDump($average, $name . '[AVERAGE: ' . count($values) . ']');
		}

		return $average;
	}
}