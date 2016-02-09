<?php
require_once '../File PHP/Gestione Account/Account.php';
/**
 * Classe Test in riferimento alla classe Account.
 * @see Account
 */
class AccountTest extends PHPUnit_Framework_TestCase {

    /**
     * Riferimento globale all'oggetto di tipo Account
     * @var Account
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Account ("Egidio","Giacoia", "E.GIACOIA@HOTMAIL.IT" , "EGIDIO", "Fisciano", "Via Roma" , 85040, "3284874895", "UTENTE");
       
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers Account::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
       $this->assertEquals("Egidio", $this->object->_nome);
       $this->assertEquals("Giacoia",  $this->object->_cognome);
       $this->assertEquals("E.GIACOIA@HOTMAIL.IT",  $this->object->_email);
       $this->assertEquals("EGIDIO",  $this->object->_pass);
       $this->assertEquals("Fisciano",  $this->object->_citta);
       $this->assertEquals("Via Roma",  $this->object->_indirizzo);
       $this->assertEquals(85040,  $this->object->_cap);
       $this->assertEquals("3284874895",  $this->object->_telefono);
       $this->assertEquals("UTENTE",  $this->object->_tipo);
    }

    /**
     * @covers Account::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
        $this->object->_pass = "Prova"; 
	$this->assertEquals("Egidio", $this->object->_nome);
        $this->assertEquals("Giacoia",  $this->object->_cognome);
        $this->assertEquals("E.GIACOIA@HOTMAIL.IT",  $this->object->_email);
        $this->assertEquals("Prova", $this->object->_pass);
	$this->assertEquals("Fisciano",  $this->object->_citta);
        $this->assertEquals("Via Roma",  $this->object->_indirizzo);
        $this->assertEquals(85040,  $this->object->_cap);
        $this->assertEquals("3284874895",  $this->object->_telefono);
        $this->assertEquals("UTENTE",  $this->object->_tipo);
       
    }

    /**
     * @covers Account::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
        $expected = 'Egidio  Giacoia  E.GIACOIA@HOTMAIL.IT  EGIDIO  Fisciano  Via Roma  85040  3284874895  UTENTE';
        $this->assertEquals($expected, $this->object);
    }

}
