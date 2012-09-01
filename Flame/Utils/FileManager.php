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
	 * @param \Nette\Http\FileUpload $file
	 * @return string
	 */
	public function saveFile(\Nette\Http\FileUpload $file)
	{

		if(!$file->isOk()) return;

		$this->createFolder($basePath = $this->getBasePath());
		$name = $file->name;
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
	 * @return string
	 */
	protected function getRandomFilePrefix()
	{
		return substr(md5(uniqid(microtime(), true)), 0, 5);
	}

	/**
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

}
