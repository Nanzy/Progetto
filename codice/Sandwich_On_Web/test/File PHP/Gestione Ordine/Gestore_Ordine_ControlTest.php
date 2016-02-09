<?php
require_once '../File PHP/Gestione Ordine/Gestore_Ordine_Control.php';
require_once '../File PHP/Gestione Carrello/Gestore_Carrello_Control.php';
/**
 * Classe Test in riferimento alla classe Gestore_Ordine_Control
 * @see Gestore_Ordine_Control
 * @see Ordine
 */
class Gestore_Ordine_ControlTest extends PHPUnit_Framework_TestCase {

   /**
     * Riferimento globale all'oggetto di tipo Gestore_Ordine_Control
     * @var Gestore_Ordine_Control
     */
    protected $object;
    /**
     * Riferimento globale all'oggetto di tipo Ordine
     * @var Ordine
     */
    protected $ordine;
    
    /**
     * Riferimento globale all'oggetto di tipo Gestore_Carrello_Control
     * @var Carrello
     */
    protected $carrello;
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
   
    
    protected function setUp() {
        $this->object = new Gestore_Ordine_Control();
        $this->ordine = new ordine(null, null, null, null, null, null, null, null);
        $this->carrello = new Gestore_Carrello_Control();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
        unset($this->ordine);
        $mysql_host = connection::$SERVER;
        $mysql_database = "sandwich_on_web";
        $mysql_user = connection::$USERNAME;
        $mysql_password = connection::$PASSWORD;
        # MySQL with PDO_MYSQL  
        $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
        $query = file_get_contents("../Script Database/Script_SOW_v2.sql");
        $stmt = $db->prepare($query);
        $stmt->execute();
        $query = file_get_contents("../Script Database/Popolamento - Test.sql");
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    
     /**
     * @covers Gestore_Ordine_Control::checkOut
     * @todo   Implement testCheckOut().
     */
    public function testCheckOut() {
       $this->id_menu = $this->carrello->creaMenuScelto("AMERICANO", 10, 1);
       $this->carrello->creaCompostoDa($this->id_menu, "AMERICA BURGER");
       $this->carrello->creaCompostoDa($this->id_menu, "BACON");
       $this->carrello->creaCompostoDa($this->id_menu, "LATTINA COCA COLA");
       $this->carrello->creaCompostoDa($this->id_menu, "SENAPE");
       $this->carrello->aggiungiAlCarrello($this->id_menu, "A.GIACOIA@HOTMAIL.IT");
       $this->id_ordine = $this->object->checkOut("A.GIACOIA@HOTMAIL.IT", "ALESSANDRO", "VIA ROMA 14", "21:00");
       $this->assertEquals(true, is_int($this->id_ordine));
    }
    
     /**
     * @covers Gestore_Ordine_Control::creaPossiede
     * @todo   Implement testCreaPossiede().
     */
       public function testCreaPossiede() {
       $this->id_menu = $this->carrello->creaMenuScelto("AMERICANO", 10, 1);
       $this->carrello->creaCompostoDa($this->id_menu, "AMERICA BURGER");
       $this->carrello->creaCompostoDa($this->id_menu, "BACON");
       $this->carrello->creaCompostoDa($this->id_menu, "LATTINA COCA COLA");
       $this->carrello->creaCompostoDa($this->id_menu, "SENAPE");
       $this->carrello->aggiungiAlCarrello($this->id_menu, "A.GIACOIA@HOTMAIL.IT");
       $this->id_ordine = $this->object->checkOut("A.GIACOIA@HOTMAIL.IT", "ALESSANDRO", "VIA ROMA 14", "21:00");
       $valore = $this->object->creaPossiede($this->id_ordine, $this->id_menu);
       $this->assertEquals(null, $valore);
    }
    
    /**
     * @covers Gestore_Ordine_Control::creaVisualizzaOrdiniLista
     * @todo   Implement testCreaVisualizzaOrdiniLista().
     */
    public function testCreaVisualizzaOrdiniLista() {
        echo $this->object->creaVisualizzaOrdiniLista("A.GIACOIA@HOTMAIL.IT");
    }
    
    /**
     * @covers Gestore_Ordine_Control::dettagliOrdine
     * @todo   Implement testDettagliOrdine().
     */
    public function testDettagliOrdine() {
       $this->id_menu = $this->carrello->creaMenuScelto("AMERICANO", 10, 1);
       $this->carrello->creaCompostoDa($this->id_menu, "AMERICA BURGER");
       $this->carrello->creaCompostoDa($this->id_menu, "BACON");
       $this->carrello->creaCompostoDa($this->id_menu, "LATTINA COCA COLA");
       $this->carrello->creaCompostoDa($this->id_menu, "SENAPE");
       $this->carrello->aggiungiAlCarrello($this->id_menu, "A.GIACOIA@HOTMAIL.IT");
       $this->id_ordine = $this->object->checkOut("A.GIACOIA@HOTMAIL.IT", "ALESSANDRO", "VIA ROMA 14", "21:00");
       $valore = $this->object->creaPossiede($this->id_ordine, $this->id_menu);
        echo $this->object->dettagliOrdine($this->id_ordine);
    }
    
    /**
     * @covers Gestore_Ordine_Control::cancellaOrdine
     * @todo  Implement testCancellaOrdine().
     */
    public function testCancellaOrdine() {
        $this->id_menu = $this->carrello->creaMenuScelto("AMERICANO", 10, 1);
       $this->carrello->creaCompostoDa($this->id_menu, "AMERICA BURGER");
       $this->carrello->creaCompostoDa($this->id_menu, "BACON");
       $this->carrello->creaCompostoDa($this->id_menu, "LATTINA COCA COLA");
       $this->carrello->creaCompostoDa($this->id_menu, "SENAPE");
       $this->carrello->aggiungiAlCarrello($this->id_menu, "A.GIACOIA@HOTMAIL.IT");
       $this->id_ordine = $this->object->checkOut("A.GIACOIA@HOTMAIL.IT", "ALESSANDRO", "VIA ROMA 14", "21:00");
       $this->object->creaPossiede($this->id_ordine, $this->id_menu);
      $valore =  $this->object->cancellaOrdine($this->id_ordine, "Attesa");
      $this->assertEquals(null, $valore);
    }

}
