<?php
/**
 * MailerTest.php
 *
 * @testCase Flame\Tests\Mail\MailerTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.01.13
 */

namespace Flame\Tests\Mail;

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert;

class FakeMailer extends \Flame\Mail\Mailer
{

}

class MailerTest extends \Flame\Tests\MockTestCase
{

	/**
	 * @var \Flame\Mail\Mailer
	 */
	private $mailer;


	public function setUp()
	{
		parent::setUp();

		$this->mailer = new FakeMailer;
	}

	public function testCreateMessage()
	{
		$r = $this->mailer->createMessage();
		Assert::true($r instanceof \Nette\Mail\Message);
	}

	public function testGetFileTemplate()
	{
		$fileTemplateMock = $this->mockista->create('\Nette\Templating\FileTemplate');
		$fileTemplateMock->expects('registerFilter')
			->once();
		$fileTemplateMock->expects('registerHelperLoader')
			->with('Nette\Templating\Helpers::loader')
			->once();
		$fileTemplateMock->expects('registerHelperLoader')
			->with('Flame\Templating\Helpers::loader')
			->once();
		$fileTemplateMock->expects('setFile')
			->with('path/to/template')
			->once();
		$this->mailer->injectFileTemplate($fileTemplateMock);

		$r = $this->mailer->getFileTemplate('path/to/template');
		Assert::true($r instanceof \Nette\Templating\FileTemplate);
	}

}

run(new MailerTest());
