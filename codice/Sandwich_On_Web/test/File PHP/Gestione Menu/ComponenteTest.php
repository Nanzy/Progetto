<?php
require_once '../File PHP/Gestione Menu/Componente.php';
/**
 * Classe Test in riferimento alla classe Componente.
 * @see Componente
 */
class ComponenteTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Componente
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Componente ("Burger" , "panino", "Gusto leggermente piccante", 6.50);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers Componente::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
        $this->assertEquals("Burger", $this->object->_nome);
	$this->assertEquals("panino", $this->object->_tipo);
	$this->assertEquals("Gusto leggermente piccante", $this->object->_descrizione);
	$this->assertEquals(6.50 , $this->object->_prezzo);
    }

    /**
     * @covers Componente::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
        $this->object->_descrizione = "Panino molto piccante";
	$this->assertEquals("Burger", $this->object->_nome);
	$this->assertEquals("panino", $this->object->_tipo);
	$this->assertEquals("Panino molto piccante", $this->object->_descrizione);
	$this->assertEquals(6.50 , $this->object->_prezzo);
    }

    /**
     * @covers Componente::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
       $expected = 'Burger / panino / Gusto leggermente piccante / 6.5';
       $this->assertEquals($expected, $this->object);
    }

}
