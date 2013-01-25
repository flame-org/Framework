<?php
/**
 * SelectionTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.01.13
 */

namespace Flame\Tests\Database\Table;

class FakeTable extends \Flame\Database\Table
{

	protected $name;

	protected $surname;

	public function __construct($name)
	{
		$this->name = (string) $name;
	}

	public function setName($name)
	{
		$this->name = (string) $name;
	}

	public function setSurname($surname)
	{
		$this->surname = (string) $surname;
	}
}

class SelectionTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \Flame\Database\Table\Selection
	 */
	private $selection;

	/**
	 * @var \Flame\Database\Connection
	 */
	private $connection;

	public function setUp()
	{
		$this->connection = new \Flame\Database\Connection(
			array('host' => '127.0.0.1', 'dbname' => 'testdb', 'user' => 'root', 'password' => 'root'));
		$this->selection = new \Flame\Database\Table\Selection(
			$this->connection, 'table', '\Flame\Tests\Database\Table\FakeTable', new \Nette\Database\Reflection\ConventionalReflection);
	}

	public function testCreateRow()
	{
		$failSelection = new \Flame\Database\Table\Selection(
			$this->connection, 'table', 'noTableClass', new \Nette\Database\Reflection\ConventionalReflection);
		$method = $this->getAccessibleMethod('\Flame\Database\Table\Selection', 'createRow');
		try {
			$method->invoke($failSelection, array('id' => 1));
			$this->fail('Expected exception ReflectionException');
		}catch (\ReflectionException $ex){}
	}

	public function testSetTableProperties()
	{
		$row = array(
			'id' => 1,
			'name' => 'George',
			'Surname' => 'Good'
		);

		$fakeTable = new FakeTable($row['name']);

		$method = $this->getAccessibleMethod('\Flame\Database\Table\Selection', 'setTableProperties');
		$r = $method->invoke($this->selection, $row, $fakeTable);
		$this->assertInstanceOf('\Flame\Database\Table', $r);
		$this->assertAttributeEquals(1, 'id', $r);
	}

	public function testGetTableClassParameters()
	{
		$row = array(
			'id' => 1,
			'name' => 'George',
			'Surname' => 'Good'
		);

		$reflection = new \ReflectionClass('\Flame\Tests\Database\Table\FakeTable');

		$method = $this->getAccessibleMethod('\Flame\Database\Table\Selection', 'getTableClassParameters');
		$r = $method->invoke($this->selection, $row, $reflection);
		$this->assertEquals(array('George'), $r);
	}

}
