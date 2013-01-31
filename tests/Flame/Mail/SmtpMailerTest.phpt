<?php
/**
 * SmtpMailerTest.php
 *
 * @testCase: \Flame\Tests\Mail\SmtpMailerTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests\Mail;

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert;

class SmtpMailerTest extends \Flame\Tests\TestCase
{

	public function testGetOptions()
	{
		$mailer = new \Flame\Mail\SmtpMailer(array());
		Assert::equal(array(), $mailer->getOptions());
	}

	/**
	 * @dataProvider optionsProvider
	 */
	public function testGetUserName($expected, $options)
	{
		$mailer = new \Flame\Mail\SmtpMailer($options);
		Assert::equal($expected, $mailer->getUserName());
	}

	/**
	 * @dataProvider optionsProvider
	 */
	public function testGetHostName($expected, $options)
	{
		$mailer = new \Flame\Mail\SmtpMailer($options);
		Assert::equal($expected, $mailer->getHostName());
	}

	public function optionsProvider()
	{
		return array(
			array('', array('username' => '', 'host' => '')),
			array(null, array('username', 'host')),
			array(null, array()),
		);
	}
}