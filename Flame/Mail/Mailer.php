<?php
/**
 * Mailer.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.01.13
 */

namespace Flame\Mail;

abstract class Mailer extends \Nette\Object
{

	/** @var \Nette\Templating\FileTemplate $fileTemplate */
	private $fileTemplate;

	/** @var \Nette\Mail\IMailer */
	private $mailer;

	/**
	 * @param \Nette\Mail\IMailer $mailer
	 */
	public function injectMailer(\Nette\Mail\IMailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @param \Nette\Templating\FileTemplate $fileTemplate
	 */
	public function injectFileTemplate(\Nette\Templating\FileTemplate $fileTemplate)
	{
		$this->fileTemplate = $fileTemplate;
	}

	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getFileTemplate()
	{
		$this->fileTemplate->registerFilter(\Nette\Callback::create(new \Nette\Latte\Engine()));
		$this->fileTemplate->registerHelperLoader('Nette\Templating\Helpers::loader');
		$this->fileTemplate->registerHelperLoader('Flame\Templating\Helpers::loader');
		$fileTemplate = clone $this->fileTemplate;
		return $fileTemplate;
	}

//	/**
//	 * @param \Nette\Mail\Message $message
//	 * @return bool
//	 */
//	public function send(\Nette\Mail\Message $message)
//	{
//		try{
//			$this->mailer->send($message);
//			return true;
//		}catch (\Exception $e){
//			\Nette\Diagnostics\Debugger::log($e);
//			return false;
//		}
//	}

	/**
	 * @return \Nette\Mail\Message
	 */
	public function createMessage()
	{
		return new \Nette\Mail\Message;
	}

	/**
	 * @return \Nette\Mail\SendmailMailer
	 */
	protected function getMailer()
	{
		return $this->mailer;
	}

}
