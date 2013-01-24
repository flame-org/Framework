<?php
/**
 * DriverTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.01.13
 */

namespace Flame\Tests\Database\Reposiroty;

class FakeDriver extends \Flame\Database\Repository\Driver
{
	protected $repositoryName = 'repoName';
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
		$this->connection = new \Flame\Database\Connection(array('user' => 'root', 'password' => 'root'));
		$this->driver = new FakeDriver($this->connection);
	}

	/**
	 * @expectedException \Nette\InvalidStateException
	 */
	public function testConstructor()
	{
		new FakeFailDriver($this->connection);
	}

	public function testGetTableName()
	{
		$this->assertEquals('reponame', $this->driver->getTableName());
	}

	public function testGetTable()
	{
		$method = $this->getProtectedClassMethod('\Flame\Tests\Database\Reposiroty\FakeDriver', 'getTable');
		$this->assertInstanceOf('\Flame\Database\Table\Selection', $method->invoke($this->driver));
	}

}
