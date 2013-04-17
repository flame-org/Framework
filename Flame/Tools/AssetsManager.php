<?php
/**
 * AssetsManager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Tools;

use Nette\Utils\Finder;
use Flame\Tools\Files\FileSystem;
use Flame\Utils\Assets;

class AssetsManager extends \Nette\Object
{

	/**
	 * @var string
	 */
	protected $wwwDir;

	/**
	 * @param $wwwDir
	 */
	public function __construct($wwwDir)
	{
		$this->wwwDir = (string)$wwwDir;
	}

	/**
	 * @param $filesPattern
	 * @param $directory
	 * @param string $publicDir
	 * @return array
	 */
	public function minify($filesPattern, $directory, $publicDir = '/css')
	{
		$failed = array();
		foreach (Finder::findFiles($filesPattern)->in($directory) as $filePath => $file) {
			$fileName = Assets::getFileNameFromPath($filePath);
			$content = FileSystem::read($filePath);
			$minifyContent = Assets::minifyCss($content);
			$path = $this->wwwDir . $publicDir . DIRECTORY_SEPARATOR . $fileName;
			if (!FileSystem::write($path, $minifyContent))
				$failed[] = array($filePath, $path);
		}
		return $failed;
	}

	public function minifyJS($directory, $publicDir)
	{
		$failed = array();
		foreach (Finder::findFiles('*.js')->in($directory) as $filePath => $file) {
			$fileName = Assets::getFileNameFromPath($filePath);
			$content = FileSystem::read($filePath);
			$path = $this->wwwDir . $publicDir . DIRECTORY_SEPARATOR . $fileName;
			try {
				$minifyContent = \JsMin\Minify::minify($content);
				FileSystem::write($path, $minifyContent);
			} catch (\Exception $ex) {
				$failed[] = array($filePath, $path);
			}
		}

		return $failed;

	}

	/**
	 * @param $runScriptPath
	 * @param $directory
	 * @param string $filesPattern
	 * @return array
	 */
	public function cp($runScriptPath, $directory, $filesPattern = '*')
	{
		$failed = array();
		foreach (Finder::findFiles($filesPattern)->from($runScriptPath . $directory) as $filePath => $file) {
			$path = $this->wwwDir . str_replace($runScriptPath, '', $filePath);
			if (!FileSystem::cp($filePath, $path))
				$failed[] = array($filePath, $path);
		}
		return $failed;
	}

}
