<?php
/**
 * DriverTest.php
 *
 * @testCase
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.01.13
 */

namespace Flame\Tests\Database\Reposiroty;

require_once __DIR__ . '/../../bootstrap.php';

use Tester\Assert;

class FakeDriver extends \Flame\Database\Repository\Driver
{
	protected $repositoryName = '\some\namespace\repoName';
}

class FakeFailDriver extends \Flame\Database\Repository\Driver
{

}

class DriverTest extends \Flame\Tests\TestCase
{

	/**
	 * @var FakeDriver
	 */
	private $driver;

	/**
	 * @var \Flame\Database\Connection
	 */
	private $connection;

	public function setUp()
	{
		$this->connection = new \Flame\Database\Connection(
			array('host' => '127.0.0.1', 'dbname' => 'testdb', 'user' => 'root', 'password' => 'root'));
		$this->driver = new FakeDriver($this->connection);
	}

	public function testConstructor()
	{
		Assert::throws(function (){
			new FakeFailDriver($this->connection);
		}, '\Nette\InvalidStateException');

	}

	public function testGetTableName()
	{
		Assert::equal('reponame', $this->driver->getTableName());
	}

	public function testGetTable()
	{
		$r = $this->invokeMethod($this->driver, 'getTable');
		Assert::true($r instanceof \Flame\Database\Table\Selection);
	}

}

run(new DriverTest());
