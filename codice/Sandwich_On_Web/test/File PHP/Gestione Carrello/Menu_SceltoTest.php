<?php
require_once '../File PHP/Gestione Carrello/Menu_Scelto.php';
/**
 * Classe Test in riferimento alla classe Menu_Scelto.
 * @see Menu_Scelto
 */
class Menu_SceltoTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Menu_Scelto
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Menu_Scelto(1 , "Classico", 6.50, 2);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers Menu_Scelto::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
       $this->assertEquals(1, $this->object->_id);
       $this->assertEquals("Classico", $this->object->_nome);
       $this->assertEquals(2, $this->object->_quantità);
       $this->assertEquals(6.50 , $this->object->_prezzo);
    }

    /**
     * @covers Menu_Scelto::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
      $this->object->_prezzo = 5.0;
      $this->assertEquals(1, $this->object->_id);  
      $this->assertEquals("Classico", $this->object->_nome);
      $this->assertEquals(2, $this->object->_quantità);
      $this->assertEquals(5.0 , $this->object->_prezzo);
    }

    /**
     * @covers Menu_Scelto::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
       $expected = 'Classico  6.5  2  1';
       $this->assertEquals($expected, $this->object);
    }

}
