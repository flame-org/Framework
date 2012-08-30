<?php
/**
 * TwitterRSSFeed.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    30.08.12
 */

namespace Flame\Utils;

class TwitterRSSFeed extends RSSFeed
{

	protected function load($username)
	{
		$url = 'http://twitter.com/statuses/user_timeline/' . $username . '.rss';
		return parent::load($url);
	}

	public function loadRss($username)
	{

		$key = 'twitter-rss-feed-' . $username . '-' . $this->limit;

		if(isset($this->cache[$key])){
			return $this->cache[$key];
		}

		$rss = $this->load($username);

		$this->cache->save($key, $rss, array(\Nette\Caching\Cache::EXPIRE => '+ 10 minutes'));

		return $rss;
	}

}
