<?php
require_once '../File PHP/Gestione Carrello/Carrello.php';
/**
 * Classe Test in riferimento alla classe Carrello.
 * @see Carrello
 */
class CarrelloTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Carrello
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Carrello("12.00" , "2");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
         unset($this->object);
    }

    /**
     * @covers Carrello::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
       $this->assertEquals("12.00", $this->object->_totale_prezzo);
	$this->assertEquals("2", $this->object->_totale_quantità);
    }

    /**
     * @covers Carrello::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
       $this->object->_totale_prezzo = "0";
       $this->object->_totale_quantità = "0"; 
       $this->assertEquals("0", $this->object->_totale_prezzo);
       $this->assertEquals("0", $this->object->_totale_quantità);
    }

    /**
     * @covers Carrello::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
        $expected = '12.00  2';
        $this->assertEquals($expected, $this->object);
    }

}
