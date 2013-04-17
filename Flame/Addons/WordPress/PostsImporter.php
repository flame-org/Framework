<?php
/**
 * PostsImporter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.12.12
 */

namespace Flame\Addons\WordPress;

class PostsImporter extends \Nette\Object
{

	/**
	 * @var array
	 */
	private $items;

	/**
	 * @var string
	 */
	private $exportFile;

	protected function loadItems()
	{
		$xml = simplexml_load_file($this->exportFile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->items = $xml->channel->item;
	}

	/**
	 * @param $item
	 * @return array
	 */
	protected function postToArray($item)
	{
		$post = array();

		$namespaces = $item->getNameSpaces(TRUE);

		$wp = $item->children($namespaces['wp']);

		$post['slug'] = (string)$wp->post_name;
		$post['name'] = (string)$item->title;
		$post['pubDate'] = new \DateTime($item->pubDate);
		$post['description'] = (string)$item->description;
		$post['comment'] = (string)$wp->comment_status;
		$post['status'] = (string)$wp->status;

		$category = '';
		$tags = array();

		if ($item->category) {

			foreach ($item->category as $tag) {

				if ((string)$tag['domain'] === 'post_tag') {
					$tags[] = (string)$tag['nicename'];
				}

				if ((string)$tag['domain'] === 'category') {
					$category = (string)$tag['nicename'];
					//continue;
				}
			}
		}

		$post['category'] = $category;
		$post['tags'] = $tags;

		$content = $item->children($namespaces['content']);
		$post['content'] = str_replace("<!--more-->\n\n", '', $content->encoded);
		$post['images'] = $this->findImages($post['content']);

		return $post;
	}

	/**
	 * @param $file
	 * @return array
	 */
	public function convert($file)
	{
		$this->exportFile = $file;

		$this->loadItems();

		$posts = array();

		foreach ($this->items as $item) {
			$posts[] = $this->postToArray($item);
		}

		return $posts;
	}

	/**
	 * @param $content
	 * @return mixed
	 */
	private function findImages($content)
	{
		$pattern = '/<img[^>]+src[\\s=\'"]';
		$pattern .= '+([^"\'>\\s]+)/is';

		if (preg_match_all($pattern, $content, $match)) {
			return $match;
		}
	}

}
