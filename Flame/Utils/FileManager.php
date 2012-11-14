<?php
/**
 * FileManager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    26.08.12
 */

namespace Flame\Utils;

class FileManager extends \Nette\Object
{

	/**
	 * @var string
	 */
	private $baseDir = WWW_DIR;

	/**
	 * @var string
	 */
	private $fileStorage;

	/**
	 * @param string $fileStorage
	 */
	public function setFileStorage($fileStorage)
	{
		$this->fileStorage = (string) $fileStorage;
	}

	/**
	 * Save upladed file and return absolute path
	 * @param \Nette\Http\FileUpload $file
	 * @return string
	 */
	public function saveFile(\Nette\Http\FileUpload $file)
	{

		if(!$file->isOk()) return;

		$this->createFolder($basePath = $this->getBasePath());
		$name = Strings::createSlug($file->name);
		$filePath = $basePath . DIRECTORY_SEPARATOR . $name;

		if(!file_exists($filePath)){
			$file->move($filePath);
		}else{
			$new_name = $this->getRandomFilePrefix() . '_' . $name;
			$file->move(str_replace($name, $new_name, $filePath));
			$name = $new_name;
		}

		return $this->fileStorage . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * @param $path
	 * @return bool
	 */
	public function createFolder($path)
	{
		if(!file_exists($path)){
			return @mkdir($path, 0777, true);
		}

		return true;
	}

	/**
	 * @param $filePath
	 * @return bool
	 */
	public function removeFile($filePath)
	{
		if(file_exists($filePath)){
			return @unlink($filePath);
		}

		return true;
	}

	/**
	 * @param $url
	 * @return bool|string
	 */
	public function downloadFile($url)
	{
		if($file = @file_get_contents($url)){

			$folderName = $this->baseDir . $this->fileStorage;
			$this->createFolder($folderName);
			$fileStorage = $folderName . DIRECTORY_SEPARATOR . $this->getFileName($url);

			if(@file_put_contents($fileStorage, $file)){
				return str_replace($this->baseDir, '', $fileStorage);
			}

		}

		return false;
	}

	/**
	 * Return name of file from URL or absolute path
	 * @param $path
	 * @return null
	 */
	protected function getFileName($path)
	{
		$parts = explode(DIRECTORY_SEPARATOR, $path);
		return isset($parts[count($parts) -1]) ? $parts[count($parts) -1] : null;
	}

	/**
	 * Return random prefix for existing file
	 * @return string
	 */
	protected function getRandomFilePrefix()
	{
		return Strings::random(5);
	}

	/**
	 * Implode BASE DIRECTORY and FILE STORAGE, then return path
	 * @return string
	 * @throws \Nette\InvalidStateException
	 */
	protected function getBasePath()
	{

		if(!$this->fileStorage){
			throw new \Nette\InvalidStateException('You must set "fileStorage"');
		}

		return $this->baseDir . DIRECTORY_SEPARATOR . $this->fileStorage;
	}

	/**
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
	 * @param $name
	 * @return mixed
	 */
	private function removeFileType($name)
	{
		return str_replace('.' . $this->getFileType($name), '', $name);
	}

}
