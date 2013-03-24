<?php
/**
 * CacheProvider.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.03.13
 */

namespace Flame\Caching;

use \Nette\Caching\Cache;

class CacheProvider extends \Nette\Object
{

	/** @var \Nette\Caching\Cache */
	private $cache;

	/**
	 * @param \Nette\Caching\Cache $cache
	 */
	public function __construct(Cache $cache = null)
	{
		$this->cache = $cache;
	}

	/**
	 * @return \Nette\Caching\Cache
	 */
	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * @param $dir
	 * @param null $namespace
	 * @return \Nette\Caching\Cache
	 */
	public function createCache($dir, $namespace = null)
	{
		if(!file_exists($dir))
			\Flame\Tools\Files\FileSystem::mkDir($dir);

		return new Cache(
			new \Nette\Caching\Storages\FileStorage($dir),
			$namespace
		);
	}

}
