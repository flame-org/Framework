<?php
/**
 * ConnectionTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.01.13
 */

namespace Flame\Tests\Database;

class ConnectionTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \Flame\Database\Connection
	 */
	private $connection;

	public function setUp()
	{
		$this->connection = new \Flame\Database\Connection(
			array('host' => '127.0.0.1', 'dbname' => 'testdb', 'user' => 'root', 'password' => 'root')
		);
	}

	public function testDefaultProperties()
	{
		$options = array(
			'driver' => 'mysql',
			'host' => '127.0.0.1',
			'dbname' =>'testdb',
			'user' => 'root',
			'password' => 'root',
			'prefix' => null,
			'options' => array(),
			'driver_class' => null
		);
		$this->assertAttributeEquals($options, 'options', $this->connection);
		$this->assertAttributeEquals(null, 'selectionFactory', $this->connection);
	}

	public function testRepository()
	{
		$r = $this->connection->repository('table', '\Namespace\Table');
		$factory = new \Flame\Database\Table\SelectionFactory($this->connection);
		$expected = $factory->create('table', '\Namespace\Table');
		$this->assertEquals($expected, $r);
	}

	public function testCreateDns()
	{
		$expected = 'mysql:host=127.0.0.1;dbname=testdb';
		$method = $this->getProtectedClassMethod('\Flame\Database\Connection', 'createDns');
		$this->assertEquals($expected, $method->invoke($this->connection));
	}

}
