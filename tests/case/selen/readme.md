/selen/
======
* misto pro seleniove testy
* co trida to workflow / testovany pripad

example
=======
LoginPersonTest.php


syntaxe
=======
<?php
/**
 * Popis
 *
 * @author RDPanek <rdpanek@gmail.com>
 */

class LoginPersonTest extends \NetteTestCase\TestCaseSelen
{
	/**
	 * Test prihlaseni uzivatele / zpracovani formulare
	 *
	 * @author RDPanek
	 * @group selen
	 */
	public function testLogIn()
	{

		$this->set_implicit_wait(5000);
		$this->load($this->context->parameters['url_app']);
		$this->assert_title("url_projektu");

		$this->get_element('//input[@id="frmloginForm-email"]')->send_keys(\WebDriver::BackspaceKey());
		$this->get_element('//input[@id="frmloginForm-email"]')
			->send_keys($this->context->parameters['tests']['email']);
		$this->get_element('//input[@id="frmloginForm-sendForm"]')->click();

		$this->assert_string_present("Přihlášení bylo úspěšné");
	}

}


