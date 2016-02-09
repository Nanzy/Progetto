<?php
require_once '../File PHP/Gestione Menu/Menu.php';
/**
 * Classe Test in riferimento alla classe Menu.
 * @see Menu
 */
class MenuTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Menu
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Menu("Classico", 6.50, 40);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
         unset($this->object);
    }

    /**
     * @covers Menu::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
       $this->assertEquals("Classico", $this->object->_nome);
       $this->assertEquals(6.50 , $this->object->_prezzo);
       $this->assertEquals(40, $this->object->_disponibilita);
    }

    /**
     * @covers Menu::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
       $this->object->_prezzo = 5.0;
       $this->assertEquals("Classico", $this->object->_nome);
       $this->assertEquals(5.0 , $this->object->_prezzo);
       $this->assertEquals(40, $this->object->_disponibilita);
    }

    /**
     * @covers Menu::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
        $expected = 'Classico  6.5  40';
        $this->assertEquals($expected, $this->object);
    }

}
