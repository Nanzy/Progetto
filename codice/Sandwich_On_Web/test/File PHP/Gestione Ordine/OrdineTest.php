<?php
require_once '../File PHP/Gestione Ordine/Ordine.php';
/**
 * Classe Test in riferimento alla classe Ordine.
 * @see Ordine
 */
class OrdineTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Ordine
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Ordine(1, "Egidio", "23:00", "Preparazione", "Via Roma 18", "22:00", 4, "23.00");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
         unset($this->object);
    }

    /**
     * @covers Ordine::__get
     * @todo   Implement test__get().
     */
    public function test__get() {
      $this->assertEquals(1, $this->object->_id);
			$this->assertEquals("Egidio", $this->object->_nome_utente);
			$this->assertEquals("23:00", $this->object->_tempo_attesa);
			$this->assertEquals("Preparazione" , $this->object->_stato);
			$this->assertEquals("Via Roma 18", $this->object->_indirizzo_consegna);
			$this->assertEquals("22:00" , $this->object->_orario_consegna);
			$this->assertEquals(4, $this->object->_totale_quantita);
			$this->assertEquals("23.00", $this->object->_totale_prezzo);
    }

    /**
     * @covers Ordine::__set
     * @todo   Implement test__set().
     */
    public function test__set() {
       $this->object->_stato = "Consegna";
			$this->assertEquals(1, $this->object->_id);
			$this->assertEquals("Egidio", $this->object->_nome_utente);
			$this->assertEquals("23:00", $this->object->_tempo_attesa);
			$this->assertEquals("Consegna" , $this->object->_stato);
			$this->assertEquals("Via Roma 18", $this->object->_indirizzo_consegna);
			$this->assertEquals("22:00" , $this->object->_orario_consegna);
			$this->assertEquals(4, $this->object->_totale_quantita);
			$this->assertEquals("23.00", $this->object->_totale_prezzo);
    }

    /**
     * @covers Ordine::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString() {
        $expected = "1  Egidio  23:00  Preparazione  Via Roma 18  22:00  4  23.00";
        $this->assertEquals($expected, $this->object);
    }

}
