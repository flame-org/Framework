<?php
/**
 * Class Macros
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 16.02.14
 */
namespace Flame\Templating;

use Nette\Latte\Macros\MacroSet;
use Nette\Latte\Compiler;

class Macros extends MacroSet
{

	/**
	 * @param Compiler $compiler
	 * @return void|static
	 */
	public static function install(Compiler $compiler)
	{
		$set = new static($compiler);
		$set->addMacro('ifCurrentIn', function($node, $writer)
		{
			return $writer->write('foreach (%node.array as $l) { if ($_presenter->isLinkCurrent($l)) { $_c = true; break; }} if (isset($_c)): ');
		}, 'endif; unset($_c);');
	}
} 