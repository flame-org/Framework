<?php
/**
 * Test: Flame\Tests\Security\Password
 *
 * @testCase Flame\Tests\Security\PasswordTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame\Tests\Security
 */
namespace Flame\Tests\Security;

use Flame\Types\Password;
use Tester\Assert;


$configurator = require_once __DIR__ . '/../bootstrap.php';

class PasswordTest extends \Flame\Tests\TestCase
{

	/** @var \Flame\Security\Password */
	private $password;

	public function setUp()
	{
		$this->password = new \Flame\Security\Password;
	}

	public function testCreateRandom()
	{
		Assert::null($this->password->getObject());
		Assert::null($this->password->getPassword());
		$password = $this->password->createRandom();
		Assert::true($password instanceof \Flame\Security\Password);
		Assert::true(is_string($password->getPassword()));
		Assert::true($password->getObject() instanceof Password);
	}
}

id(new PasswordTest($configurator))->run();