<?php
/**
 * ThumbnailsCreator.php
 *
 * @author  uestla
 * @package Flame
 *
 * @date    02.08.12
 */

namespace Flame\Utils;

use \Nette\Image;

class ThumbnailsCreator extends \Nette\Object
{

	private $thumbDirUri;
	private $imageDirUri;
	private $baseDir;

	public function __construct(array $params = array())
	{
		if(isset($params['baseDir'])) $this->baseDir = $params['baseDir'];
		if(isset($params['thumbDir'])) $this->thumbDirUri = $params['thumbDir'];
		if(isset($params['imageDir'])) $this->imageDirUri = $params['imageDir'];
	}

	/**
	 * Vytvoreni miniatury obrazku a vraceni jeho URI
	 *
	 * @param  string relativni URI originalu (zacina se v document_rootu)
	 * @param  NULL|int sirka miniatury
	 * @param  NULL|int vyska miniatury
	 * @return string absolutni URI miniatury
	 */
	public function thumb($origName, $width, $height = NULL)
	{

		if(is_null($this->baseDir) or is_null($this->imageDirUri) or is_null($this->thumbDirUri)){
			throw new \Nette\InvalidArgumentException;
		}

		$thumbDirPath = $this->baseDir . '/' . trim($this->thumbDirUri, '/\\');
		$origPath = $this->baseDir . '/' . $this->imageDirUri . '/' . $origName;

		$this->createDirForThumbnails($thumbDirPath);

		if (($width === NULL && $height === NULL) || !is_file($origPath) || !is_dir($thumbDirPath) || !is_writable($thumbDirPath))
			return $origName;

		$thumbName = $this->getThumbName($origName, $width, $height, filemtime($origPath));
		$thumbUri = trim($this->thumbDirUri, '/\\') . '/' . $thumbName;
		$thumbPath = $thumbDirPath . '/' . $thumbName;

		// miniatura jiz existuje
		if (is_file($thumbPath)) {
			return $thumbUri;
		}


		try {

			$image = Image::fromFile($origPath);

			// zachovani pruhlednosti u PNG
			$image->alphaBlending(FALSE);
			$image->saveAlpha(TRUE);

			$origWidth = $image->getWidth();
			$origHeight = $image->getHeight();

			$image->resize($width, $height,
				$width !== NULL && $height !== NULL ? Image::STRETCH : Image::FIT)
				->sharpen();

			$newWidth = $image->getWidth();
			$newHeight = $image->getHeight();

			// doslo ke zmenseni -> ulozime miniaturu
			if ($newWidth !== $origWidth || $newHeight !== $origHeight) {

				$image->save($thumbPath);

				if (is_file($thumbPath))
					return $thumbUri;
				else
					return $origName;

			} else {
				return $origName;
			}

		} catch (Exception $e) {
			return $origName;
		}
	}



	/**
	 * Vytvori jmeno generovane miniatury
	 *
	 * @param  string relativni cesta (document_root/$relPath)
	 * @param  int sirka
	 * @param  int vyska
	 * @param  int timestamp zmeny originalu
	 * @return string
	 */
	private function getThumbName($relPath, $width, $height, $mtime)
	{
		$sep = '.';
		$tmp = explode($sep, $relPath);
		$ext = array_pop($tmp);

		// cesta k obrazku (ale bez pripony)
		$relPath = implode($sep, $tmp);

		// pripojime rozmery a mtime
		$relPath .= $width . 'x' . $height . '-' . $mtime;

		// zahashujeme a vratime priponu
		$relPath = md5($relPath) . $sep . $ext;

		return $relPath;
	}

	private function createDirForThumbnails($filepath)
	{
		if(!file_exists($filepath)) return chmod($filepath, 0777, true);
	}

}
