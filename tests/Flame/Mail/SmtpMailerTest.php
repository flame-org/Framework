<?php
/**
 * SmtpMailerTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests\Mail;

class SmtpMailerTest extends \Flame\Tests\TestCase
{

	public function testGetOptions()
	{
		$mailer = new \Flame\Mail\SmtpMailer(array());
		$this->assertEquals(array(), $mailer->getOptions());
	}

	public function testGetUserName()
	{
		$case1 = array('username' => '', 'host' => '');
		$mailer = new \Flame\Mail\SmtpMailer($case1);
		$this->assertEquals($case1['username'], $mailer->getUserName());

		$case2 = array('username', 'host' => '');
		$mailer = new \Flame\Mail\SmtpMailer($case2);
		$this->assertEquals($case1['username'], $mailer->getUserName());

		$case3 = array();
		$mailer = new \Flame\Mail\SmtpMailer($case3);
		$this->assertNull($mailer->getUserName());
	}

	public function testGetHostName()
	{
		$case1 = array('username' => '', 'host' => '');
		$mailer = new \Flame\Mail\SmtpMailer($case1);
		$this->assertEquals($case1['username'], $mailer->getHostName());

		$case2 = array('username', 'host');
		$mailer = new \Flame\Mail\SmtpMailer($case2);
		$this->assertEquals($case1['username'], $mailer->getHostName());

		$case3 = array();
		$mailer = new \Flame\Mail\SmtpMailer($case3);
		$this->assertNull($mailer->getHostName());
	}
}
