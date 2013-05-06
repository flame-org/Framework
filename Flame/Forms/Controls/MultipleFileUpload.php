<?php
/**
 * MultipleFileUpload.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.08.12
 */

namespace Flame\Forms\Controls;

use Nette\Http\FileUpload,
	Nette\Forms\Controls\UploadControl;

class MultipleFileUpload extends UploadControl
{

	/**
	 * @param null $label
	 */
	public function __construct($label = null)
	{
		parent::__construct($label);
		$this->control->type = 'file';
		$this->control->multiple = "true";
	}

	/**
	 * Generates control's HTML element.
	 *
	 * @return \Nette\Utils\Html
	 */
	public function getControl()
	{
		$control = parent::getControl();
		$control->name = $this->getHtmlName() . "[]";
		$control->class[] = "multiple-file-upload";

		return $control;
	}

	/**
	 * Sets control's value.
	 *
	 * @param  array|Nette\Http\FileUpload
	 * @return Nette\Http\FileUpload  provides a fluent interface
	 */
	public function setValue($value)
	{
		if (is_array($value)) {
			$this->value = $value;

		} elseif ($value instanceof FileUpload) {
			$this->value = $value;

		} else {
			$this->value = new FileUpload(null);
		}

		return $this;
	}

	/**
	 * FileSize validator: is file size in limit?
	 *
	 * @param \Nette\Forms\Controls\UploadControl $control
	 * @param                                     $limit
	 * @return bool
	 */
	public static function validateFileSize(UploadControl $control, $limit)
	{
		$files = $control->getValue();
		if (is_array($files) and count($files)) {
			foreach ($files as $file) {
				if (!$file instanceof FileUpload or $file->getSize() >= $limit)
					return false;
			}

			return true;
		} else {
			return $files instanceof FileUpload && $files->getSize() <= $limit;
		}

	}

	/**
	 * MimeType validator: has file specified mime type?
	 *
	 * @param UploadControl $control
	 * @param               $mimeType
	 * @return bool
	 */
	public static function validateMimeType(UploadControl $control, $mimeType)
	{
		$files = $control->getValue();

		if (is_array($files) and count($files)) {
			foreach ($files as $file) {
				if (self::validateFileMimeType($file, $mimeType))
					return true;
			}
		} else {
			if (self::validateFileMimeType($files, $mimeType))
				return true;
		}

		return false;

	}

	/**
	 * @param $file
	 * @param $mimeType
	 * @return bool
	 */
	protected static function validateFileMimeType($file, $mimeType)
	{
		if ($file instanceof FileUpload) {
			$type = strtolower($file->getContentType());
			$mimeTypes = is_array($mimeType) ? $mimeType : explode(',', $mimeType);
			if (in_array($type, $mimeTypes, true)) {
				return true;
			}
			if (in_array(preg_replace('#/.*#', '/*', $type), $mimeTypes, true)) {
				return true;
			}
		}
	}

	/**
	 * @param \Nette\Forms\Controls\UploadControl $control
	 * @return bool
	 */
	public static function validateImage(UploadControl $control)
	{
		$files = $control->getValue();

		if (is_array($files) and count($files)) {
			foreach ($files as $file) {
				if (!$file instanceof FileUpload or !$file->isImage())
					return false;
			}

			return true;
		} else {
			return $files instanceof FileUpload && $files->isImage();
		}

	}

	/**
	 * Has been any file uploaded?
	 *
	 * @return bool
	 */
	public function isFilled()
	{

		if (is_array($this->value) and count($this->value)) {
			foreach ($this->value as $file) {
				if (!$file instanceof FileUpload or !$file->isOk())
					return false;
			}

			return true;
		} else {
			return $this->value instanceof FileUpload && $this->value->isOk();
		}
	}

}
