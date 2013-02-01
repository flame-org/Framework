<?php
/**
 * SelectionTest.php
 *
 * @testCase
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.01.13
 */

namespace Flame\Tests\Database\Table;

require_once __DIR__ . '/../../bootstrap.php';

use Tester\Assert;

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

		Assert::throws(function () use ($failSelection) {
			$this->invokeMethod($failSelection, 'createRow', array(array('id' => 1)));
		}, '\ReflectionException');
	}

	public function testSetTableProperties()
	{
		$row = array(
			'id' => 1,
			'name' => 'George',
			'Surname' => 'Good'
		);

		$fakeTable = new FakeTable($row['name']);


		$r = $this->invokeMethod($this->selection, 'setTableProperties', array($row, $fakeTable));
		Assert::true($r instanceof \Flame\Database\Table);
		Assert::equal(1, $this->getAttributeValue($r, 'id'));
	}

	public function testGetTableClassParameters()
	{
		$row = array(
			'id' => 1,
			'name' => 'George',
			'Surname' => 'Good'
		);

		$reflection = new \ReflectionClass('\Flame\Tests\Database\Table\FakeTable');
		$r = $this->invokeMethod($this->selection, 'getTableClassParameters', array($row, $reflection));
		Assert::equal(array('George'), $r);
	}

}

run(new SelectionTest());