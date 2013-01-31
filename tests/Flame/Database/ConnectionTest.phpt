<?php
/**
 * ConnectionTest.php
 *
 * @testCase
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.01.13
 */

namespace Flame\Tests\Database;

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert;

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
		Assert::equal($options, $this->getAttributeValue($this->connection, 'options'));
		Assert::null($this->getAttributeValue($this->connection, 'selectionFactory'));
	}

	public function testRepository()
	{
		$r = $this->connection->repository('table', '\Namespace\Table');
		Assert::true($r instanceof \Nette\Database\Table\Selection);
		Assert::equal('\Namespace\Table', $this->getAttributeValue($r, 'tableClass'));
	}

	public function testSetSelectionFactory()
	{
		Assert::null($this->getAttributeValue($this->connection, 'selectionFactory'));
		$factory = new \Nette\Database\Table\SelectionFactory($this->connection);
		$r = $this->connection->setSelectionFactory($factory);
		Assert::same($factory, $this->getAttributeValue($this->connection, 'selectionFactory'));
		Assert::same($this->connection, $r);
	}

	public function testCreateDns()
	{
		$expected = 'mysql:host=127.0.0.1;dbname=testdb';
		Assert::equal($expected, $this->invokeMethod($this->connection, 'createDns'));
	}

}

run(new ConnectionTest());
