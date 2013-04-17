<?php
/**
 * XML.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    26.03.13
 */

namespace Flame\Utils;

/**
 * @author Adrien aka Gaarf & contributors
 */
class XML extends \Nette\Object
{

	/**
	 * Static class - cannot be instantiated.
	 *
	 * @throws \Flame\StaticClassException
	 */
	final public function __construct()
	{
		throw new \Flame\StaticClassException;
	}

	/**
	 * @param $xmlstr
	 * @return array|string
	 */
	public static function stringToArray($xmlstr)
	{
		$doc = new \DOMDocument();
		$doc->loadXML($xmlstr);
		$root = $doc->documentElement;
		$output = static::nodeToArray($root);
		$output['@root'] = $root->tagName;
		return $output;
	}

	/**
	 * @param $node
	 * @return array|string
	 */
	public static function nodeToArray($node)
	{
		$output = array();
		switch ($node->nodeType) {

			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;

			case XML_ELEMENT_NODE:
				for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
					$child = $node->childNodes->item($i);
					$v = static::nodeToArray($child);
					if (isset($child->tagName)) {
						$t = $child->tagName;
						if (!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					} elseif ($v || $v === '0') {
						$output = (string)$v;
					}
				}
				if ($node->attributes->length && !is_array($output)) { //Has attributes but isn't an array
					$output = array('@content' => $output); //Change output into an array.
				}
				if (is_array($output)) {
					if ($node->attributes->length) {
						$a = array();
						foreach ($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string)$attrNode->value;
						}
						$output['@attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if (is_array($v) && count($v) == 1 && $t != '@attributes') {
							$output[$t] = $v[0];
						}
					}
				}
				break;
		}
		return $output;
	}

}
