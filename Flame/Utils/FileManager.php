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
	 * @var array
	 */
	private $fileStorage;

	/**
	 * @param array $fileStorage
	 */
	public function setFileStorage($fileStorage)
	{
		$this->fileStorage = (string) $fileStorage;
	}

	/**
	 * @param \Nette\Http\FileUpload $file
	 * @return string
	 * @throws \Nette\InvalidStateException
	 */
	public function saveFile(\Nette\Http\FileUpload $file)
	{

		if(!$this->fileStorage){
			throw new \Nette\InvalidStateException('You must set "fileStorage"');
		}
		
		$name = $file->name;
		$filePath = $this->fileStorage . DIRECTORY_SEPARATOR . $name;

		$this->createFolder($this->fileStorage);

		if(!file_exists($filePath)){
			$file->move($filePath);
		}else{
			$new_name = $this->getRandomFilePrefix() . '_' . $name;
			$file->move(str_replace($name, $new_name, $filePath));
			$name = $new_name;

		}
		return $name;
	}

	public function createFolder($path)
	{
		if(!file_exists($path)){
			return @mkdir($path, 0777, true);
		}

		return true;
	}

	public function removeFile($filePath)
	{
		if(file_exists($filePath)){
			return @unlink($filePath);
		}

		return true;
	}

	protected function getRandomFilePrefix()
	{
		return substr(md5(uniqid(microtime(), true)), 0, 5);
	}

}
