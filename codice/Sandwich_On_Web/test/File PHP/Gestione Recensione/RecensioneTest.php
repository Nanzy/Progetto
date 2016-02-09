<?php
require_once '../File PHP/Gestione Recensione/Recensione.php';
/**
 * Classe Test in riferimento alla classe Recensione.
 * @see Recensione
 */
class RecensioneTest extends PHPUnit_Framework_TestCase {

    /**
     * Riferimento globale all'oggetto di tipo Recensione
     * @var Recensione
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Recensione("Ottimo sito" , "Il testo della recensione", "Egix", 4);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers Recensione::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
        $this->assertEquals("Ottimo sito", $this->object->_titolo);
	$this->assertEquals("Il testo della recensione", $this->object->_testo);
	$this->assertEquals("Egix", $this->object->_nickname);
	$this->assertEquals(4, $this->object->_apprezzamento);
    }

    /**
     * @covers Recensione::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
        $this->object->_apprezzamento = 5;
        $this->assertEquals("Ottimo sito", $this->object->_titolo);
        $this->assertEquals("Il testo della recensione", $this->object->_testo);
	$this->assertEquals("Egix", $this->object->_nickname);
	$this->assertEquals(5, $this->object->_apprezzamento);
    }

    /**
     * @covers Recensione::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
         $expected = 'Ottimo sito/Il testo della recensione/Egix/4';
        $this->assertEquals($expected, $this->object);
    }

}
