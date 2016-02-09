<?php
require_once '../File PHP/Gestione Carrello/Gestore_Carrello_Control.php';
/**
 * Classe Test in riferimento alla classe Gestore_Carrello_Control
 * @see Gestore_Carrello_Control
 * @see Carrello
 */
class Gestore_Carrello_ControlTest extends PHPUnit_Framework_TestCase {

    /**
     * Riferimento globale all'oggetto di tipo Gestore_Carrello_Control
     * @var Gestore_Carrello_Control
     */
    protected $object;
    /**
     * Riferimento globale all'oggetto di tipo Carrello
     * @var Carrello
     */
    protected $carrello;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Gestore_Carrello_Control();
        $this->carrello = new carrello(null, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
         unset($this->object);
         unset($this->carrello);
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
     * @covers Gestore_Carrello_Control::creaMenuScelto
     * @todo   Implement testCreaMenuScelto().
     */
    public function testCreaMenuScelto() {
        $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
        $this->assertEquals(true, is_int($id));
    }
    
     /**
     * @covers Gestore_Carrello_Control::creaCompostoDa
     * @todo   Implement testCreaCompostoDa().
     */
    public function testCreaCompostoDa() {
       $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
       $valore = $this->object->creaCompostoDa($id, "BOX MENU CHEESEBURGER");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "ANELLI DI CIPOLLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "LATTINA COCA COLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "SENAPE");
       $this->assertEquals(null, $valore);
    }
    
    /**
     * @covers Gestore_Carrello_Control::aggiungiAlCarrello
     * @todo   Implement testAggiungiAlCarrello().
     */
    public function testAggiungiAlCarrello() {
           $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
       $valore = $this->object->creaCompostoDa($id, "BOX MENU CHEESEBURGER");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "ANELLI DI CIPOLLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "LATTINA COCA COLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "SENAPE");
       $this->assertEquals(null, $valore);
        $valore = $this->object->aggiungiAlCarrello($id, "A.GIACOIA@HOTMAIL.IT");
        $this->assertEquals(null, $valore);
    }
    
    
    /**
     * @covers Gestore_Carrello_Control::getCarrello
     * @todo   Implement testGetCarrello().
     */
    public function testGetCarrello() {
        $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
        $valore = $this->object->creaCompostoDa($id, "BOX MENU CHEESEBURGER");
        $this->assertEquals(null, $valore);
        $valore = $this->object->creaCompostoDa($id, "ANELLI DI CIPOLLA");
        $this->assertEquals(null, $valore);
        $valore = $this->object->creaCompostoDa($id, "LATTINA COCA COLA");
        $this->assertEquals(null, $valore);
        $valore = $this->object->creaCompostoDa($id, "SENAPE");
        $this->assertEquals(null, $valore);
        $valore = $this->object->aggiungiAlCarrello($id, "A.GIACOIA@HOTMAIL.IT");
        $this->assertEquals(null, $valore);
        $this->carrello = $this->object->getCarrello("A.GIACOIA@HOTMAIL.IT");
        $this->assertEquals(0, $this->carrello->_totale_quantità);
        $this->assertEquals(0, $this->carrello->_totale_prezzo);
    }
    
    /**
     * @covers Gestore_Carrello_Control::creaVisualizzaCarrelloLista
     * @todo   Implement testCreaVisualizzaCarrelloLista().
     */
    public function testCreaVisualizzaCarrelloLista() {
        echo $this->object->creaVisualizzaCarrelloLista("A.GIACOIA@HOTMAIL.IT");
    }
    
    /**
     * @covers Gestore_Carrello_Control::dettagliMenù
     * @todo   Implement testDettagliMenù().
     */
    public function testDettagliMenù() {
       $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
       $valore = $this->object->creaCompostoDa($id, "BOX MENU CHEESEBURGER");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "ANELLI DI CIPOLLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "LATTINA COCA COLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "SENAPE");
       $this->assertEquals(null, $valore);
        $valore = $this->object->aggiungiAlCarrello($id, "A.GIACOIA@HOTMAIL.IT");
        $this->assertEquals(null, $valore);
        echo $this->object->dettagliMenù($id);
    }
    
    /**
     * @covers Gestore_Carrello_Control::eliminaMenù
     * @todo   Implement testEliminaMenù().
     */
    public function testEliminaMenù() {
           $id = $this->object->creaMenuScelto("Classico", 8.00, 2);
       $valore = $this->object->creaCompostoDa($id, "BOX MENU CHEESEBURGER");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "ANELLI DI CIPOLLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "LATTINA COCA COLA");
       $this->assertEquals(null, $valore);
       $valore = $this->object->creaCompostoDa($id, "SENAPE");
       $this->assertEquals(null, $valore);
        $valore = $this->object->aggiungiAlCarrello($id, "A.GIACOIA@HOTMAIL.IT");
        $this->assertEquals(null, $valore);
      $valore = $this->object->eliminaMenù($id);
      $this->assertEquals(null, $valore);
    }

    /**
     * @covers Gestore_Carrello_Control::svuotaCarrello
     * @todo   Implement testSvuotaCarrello().
     */
    public function testSvuotaCarrello() {
       $id_menu_1 = $this->object->creaMenuScelto("AMERICANO", 10, 1);
       $this->object->creaCompostoDa($id_menu_1, "AMERICA BURGER");
       $this->object->creaCompostoDa($id_menu_1, "BACON");
       $this->object->creaCompostoDa($id_menu_1, "LATTINA COCA COLA");
       $this->object->creaCompostoDa($id_menu_1, "SENAPE");
       $this->object->aggiungiAlCarrello($id_menu_1, "A.GIACOIA@HOTMAIL.IT");
       $id_menu_2 = $this->object->creaMenuScelto("CLASSICO", 8, 1);
       $this->object->creaCompostoDa($id_menu_2, "BOX MENU CHEESEBURGER");
       $this->object->creaCompostoDa($id_menu_2, "ANELLI DI CIPOLLA");
       $this->object->creaCompostoDa($id_menu_2, "LATTINA COCA COLA");
       $this->object->creaCompostoDa($id_menu_2, "SENAPE");
       $this->object->aggiungiAlCarrello($id_menu_2, "A.GIACOIA@HOTMAIL.IT");
       $menu_codici = array($id_menu_1,$id_menu_2);
       $valore = $this->object->svuotaCarrello($menu_codici);
       $this->assertEquals(null, $valore);
    }
}
