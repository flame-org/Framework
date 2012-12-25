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
	protected $outputDirPath;

	/**
	 * @param $outputDirPath
	 */
	public function __construct($outputDirPath)
	{
		$this->outputDirPath = (string) $outputDirPath;
	}

	/**
	 * @param $path
	 */
	public function setOutputDir($path)
	{
		$this->outputDirPath = (string) $path;
	}

	/**
	 * @param $filesPattern
	 * @param $directory
	 * @return array
	 */
	public function minify($filesPattern, $directory)
	{
		$failed = array();
		foreach (Finder::findFiles($filesPattern)->in($directory) as $filePath => $file) {
			$fileName = Assets::getFileNameFromPath($filePath);
			$content = FileSystem::read($filePath);
			$minifyContent = Assets::minifyCss($content);
			$path = $this->outputDirPath . DIRECTORY_SEPARATOR . $fileName;
			if(!FileSystem::write($path, $minifyContent))
				$failed[] = array($filePath, $path);
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
		foreach (Finder::findFiles($filesPattern)->in($runScriptPath . $directory) as $filePath => $file) {
			$fileName = Assets::getFileNameFromPath($filePath);
			$content = FileSystem::read($filePath);
			$path = $this->outputDirPath . str_replace($runScriptPath, '', $filePath);
			if(!FileSystem::write($path, $content))
				$failed[] = array($filePath, $path);
		}
		return $failed;
	}

}
