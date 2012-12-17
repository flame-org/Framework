<?php
/**
 * SmtpMailer.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    26.11.12
 */

namespace Flame\Mail;

class SmtpMailer extends \Nette\Mail\SmtpMailer
{

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array())
	{
		parent::__construct($options);

		$this->options = $options;
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

}
