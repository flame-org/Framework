<?php
/**
 * AssetsTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Tests\Utils;

use Flame\Utils\Assets;

class AssetsTest extends \Flame\Tests\TestCase
{

	/**
	 * @dataProvider providerPaths
	 * @param $path
	 * @param $result
	 */
	public function testGetFileNameFromPath($path, $result)
	{
		$this->assertEquals($result, Assets::getFileNameFromPath($path));
	}

	/**
	 * @return array
	 */
	public function providerPaths()
	{
		return array(
			array('path/to/something/file.jpg', 'file.jpg'),
			array('file.jpg', 'file.jpg'),
			array('/path/to/file.jpg', 'file.jpg'),
			array('', ''),
			array('path/file', 'file'),
		);
	}

	/**
	 * @dataProvider providerFileNames
	 * @param $filename
	 * @param $result
	 */
	public function testModifyType($filename, $result)
	{
		$this->assertEquals($result, Assets::modifyType($filename));
	}

	public function providerFileNames()
	{
		return array(
			array('style.less', 'style.css'),
			array('style.css', 'style.css'),
			array('style', 'style'),
			array('/path/to/style.less', '/path/to/style.css')
		);
	}

	public function testMinifyCss()
	{
		$css = "/**
			 * html5doctor.com Reset Stylesheet v1.6.1 (http://html5doctor.com/html-5-reset-stylesheet/)
			 * Richard Clark (http://richclarkdesign.com)
			 * http://cssreset.com
			 */
			html, body, div, span, object, iframe,
			h1, h2, h3, h4, h5, h6, p, blockquote, pre,
			abbr, address, cite, code,
			del, dfn, em, img, ins, kbd, q, samp,
			small, strong, sub, sup, var,
			b, i,
			dl, dt, dd, ol, ul, li,
			fieldset, form, label, legend,
			table, caption, tbody, tfoot, thead, tr, th, td,
			article, aside, canvas, details, figcaption, figure,
			footer, header, hgroup, menu, nav, section, summary,
			time, mark, audio, video {
			    margin:0;
			    padding:0;
			    border:0;
			    outline:0;
			    font-size:100%;
			    vertical-align:baseline;
			    background:transparent;
			}
			body {
			    line-height:1;
			}
			article,aside,details,figcaption,figure,
			footer,header,hgroup,menu,nav,section {
			    display:block;
			}
			nav ul {
			    list-style:none;
			}
			blockquote, q {
			    quotes:none;
			}
			blockquote:before, blockquote:after,
			q:before, q:after {
			    content:'';
			    content:none;
			}";

		$afterMinifyCss = "html, body, div, span, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,abbr, address, cite, code,del, dfn, em, img, ins, kbd, q, samp,small, strong, sub, sup, var,b, i,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, figcaption, figure,footer, header, hgroup, menu, nav, section, summary,time, mark, audio, video {margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}body {line-height:1;}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section {display:block;}nav ul {list-style:none;}blockquote, q {quotes:none;}blockquote:before, blockquote:after,q:before, q:after {content:'';content:none;}";

		$this->assertEquals($afterMinifyCss, Assets::minifyCss($css));
	}

}
