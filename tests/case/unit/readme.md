/case/unit/
==========

* misto pro jednotkove a integracni testy
* struktura testu reflektuje skeleton aplikace

example
=======
+ app/
		+	presenter
				+ HomePagePresenterTest.php


syntaxe
=======
<?php
/**
 * Ukazka testovaci tridy
 *
 * @Date: 11-01-2012
 * @author RDPanek <rdpanek@gmail.com>
 */

namespace Tests;

class FirstTest extends \NetteTestCase\TestCase
{

	public function setUp()
	{
		parent::setUp();
	}

	/**
	 * Popis
	 *
	 * @covers \TridaAjeji::testovanaMetoda
	 * @author JmenoAutora
	 * @group unit
	 */
	public function testTrue()
	{
		$this->assertTrue(True);
	}

}