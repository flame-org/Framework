<?php
/**
 * FileManager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    13.12.12
 */

namespace Flame\Tools\Files;

use Nette\Http\FileUpload;
use Nette\InvalidArgumentException;
use Nette\Object;
use Nette\Utils\Strings;
use Nette\Utils\FileSystem;

class FileManager extends Object
{

	/** @var string */
	private $baseDirPath;

	/** @var string */
	private $filesDirPath;

	/**
	 * @param        $baseDirPath
	 * @param string $filesDirPath
	 */
	public function __construct($baseDirPath, $filesDirPath = '/media/images')
	{
		$this->baseDirPath = (string) $baseDirPath;
		$this->filesDirPath = (string) $filesDirPath;
	}

	/**
	 * @param $path
	 * @return $this
	 */
	public function setFilesDir($path)
	{
		$this->filesDirPath = (string)$path;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilesDir()
	{
		return $this->filesDirPath;
	}

	/**
	 * @return string
	 */
	public function getBaseDir()
	{
		return $this->baseDirPath;
	}

	/**
	 * Save uploaded file and return absolute path
	 *
	 * @param \Nette\Http\FileUpload $file
	 * @param null $name
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function saveFile(FileUpload $file, $name = null)
	{

		FileSystem::createDir($this->getAbsolutePath(), 0777);

		if (!$file->isOk()) {
			throw new InvalidArgumentException('File ' . $file->getName() . ' is not valid.');
		}

		if(!$name) {
			$name = $file->getSanitizedName();
		}

		$filePath = $this->getAbsolutePath() . DIRECTORY_SEPARATOR . $name;

		if (!file_exists($filePath)) {
			$file->move($filePath);
		} else {
			$new_name = Strings::random(3) . '_' . $name;
			$file->move(str_replace($name, $new_name, $filePath));
			$name = $new_name;
		}

		return $this->filesDirPath . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * @return string
	 */
	public function getAbsolutePath()
	{
		return $this->baseDirPath . $this->filesDirPath;
	}
}
