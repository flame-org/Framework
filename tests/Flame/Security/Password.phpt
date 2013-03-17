<?php
/**
 * Test: Flame\Tests\Security\Password
 *
 * @testCase Flame\Tests\Security\PasswordTest
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame\Tests\Security
 */
namespace Flame\Tests\Security;

use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class PasswordTest extends \Flame\Tests\TestCase
{

	/** @var \Flame\Security\Password */
	private $password;

	public function setUp()
	{
		$this->password = new \Flame\Security\Password;
	}

	public function testDefault()
	{
		Assert::null($this->getAttributeValue($this->password, 'password'));
		Assert::null($this->getAttributeValue($this->password, 'object'));
	}

	public function testCreateRandom()
	{
		$password = $this->password->createRandom();
		Assert::true($password instanceof \Flame\Security\Password);
		Assert::true($this->getAttributeValue($this->password, 'object') instanceof \Flame\Types\Password);
	}
}

run(new PasswordTest());