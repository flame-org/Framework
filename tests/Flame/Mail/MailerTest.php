<?php
/**
 * MailerTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.01.13
 */

namespace Flame\Tests\Mail;

class MailerTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \Flame\Mail\Mailer
	 */
	private $mailer;

	public function setUp()
	{
		$this->mailer = $this->getMockForAbstractClass('\Flame\Mail\Mailer');
	}

	public function testCreateMessage()
	{
		$this->assertInstanceOf('\Nette\Mail\Message', $this->mailer->createMessage());
	}

	public function testGetFileTemplate()
	{
		$fileTemplateMock = $this->getMock('\Nette\Templating\FileTemplate');
		$fileTemplateMock->expects($this->once())
			->method('registerFilter');
		$fileTemplateMock->expects($this->once())
			->method('registerHelperLoader')
			->with($this->equalTo('Nette\Templating\Helpers::loader'));
		$this->mailer->injectFileTemplate($fileTemplateMock);

		$this->assertInstanceOf('\Nette\Templating\FileTemplate', $this->mailer->getFileTemplate());
	}

}
