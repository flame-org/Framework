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

use Flame\Utils\Strings;

class FileManager extends \Nette\Object
{

	/**
	 * @var string
	 */
	protected $baseDirPath;

	/**
	 * @var string
	 */
	protected $filesDirPath;

	/**
	 * @param $baseDirPath
	 * @param string $filesDirPath
	 */
	public function __construct($baseDirPath, $filesDirPath = 'media/images')
	{
		$this->baseDirPath = (string) $baseDirPath;
		$this->filesDirPath = (string) $filesDirPath;
	}

	/**
	 * @param $path
	 */
	public function setFilesDir($path)
	{
		$this->filesDirPath = (string) $path;
	}

	/**
	 * Save upladed file and return absolute path
	 * @param \Nette\Http\FileUpload $file
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function saveFile(\Nette\Http\FileUpload $file)
	{

		if(!$file->isOk())
			throw new \Nette\InvalidArgumentException('File ' . $file->name . ' is not valid.');

		FileSystem::mkDir($this->getAbsolutePath(), true, 0777, false);
		$name = Strings::webalize($this->removeFileType($file->name)) . '.' . $this->getFileType($file->name);
		$filePath = $this->getAbsolutePath() . DIRECTORY_SEPARATOR . $name;

		if(!file_exists($filePath)){
			$file->move($filePath);
		}else{
			$new_name = Strings::random(5) . '_' . $name;
			$file->move(str_replace($name, $new_name, $filePath));
			$name = $new_name;
		}

		return $this->filesDirPath . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * Save file from url on server
	 * @param $url
	 * @return bool|int
	 */
	public function downloadFile($url)
	{
		$fileDir = $this->getAbsolutePath() . $this->getFileName($url);

		if($file = FileSystem::read($url, false))
			return FileSystem::write($fileDir, $file, true, 0777, false);

		return false;
	}

	/**
	 * Return ending of filename
	 * @param $name
	 * @return null
	 */
	protected function getFileType($name)
	{
		$neeadles = explode('.', $name);
		$last = count($neeadles) - 1;
		return (isset($neeadles[$last])) ? $neeadles[$last] : null;
	}

	/**
	 * Return name of file without ending
	 * @param $name
	 * @return mixed
	 */
	protected function removeFileType($name)
	{
		return str_replace('.' . $this->getFileType($name), '', $name);
	}

	/**
	 * Return name of file from URL or absolute path
	 * @param $path
	 * @return null
	 */
	protected function getFileName($path)
	{
		$parts = explode(DIRECTORY_SEPARATOR, $path);
		$index = count($parts) - 1;
		return isset($parts[$index]) ? $parts[$index] : null;
	}

	/**
	 * @return string
	 */
	protected function getAbsolutePath()
	{
		return $this->baseDirPath . $this->filesDirPath;
	}

}