<?php
require_once '../File PHP/Gestione Recensione/Gestore_Recensione_Control.php';
/**
 * Classe Test in riferimento alla classe Gestore_Recensione_Control
 * @see Gestore_Recensione_Control
 * @see Recensione
 */
class Gestore_Recensione_ControlTest extends PHPUnit_Framework_TestCase {

     /**
     * Riferimento globale all'oggetto di tipo Gestore_Recensione_Control
     * @var Gestore_Recensione_Control
     */
    protected $object;
    /**
     * Riferimento globale all'oggetto di tipo Recensione
     * @var Recensione
     */
    protected $reecnsione;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Gestore_Recensione_Control();
        $this->recensione = new recensione(null, null, null, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
        unset($this->recensione);
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
     * @covers Gestore_Recensione_Control::creaVisualizzaRecensioneLista
     * @todo   Implement testCreaVisualizzaRecensioneLista().
     */
    public function testCreaVisualizzaRecensioneLista() {
        echo $this->object->creaVisualizzaRecensioneLista();
    }

    /**
     * @covers Gestore_Recensione_Control::creaRecensione
     * @todo   Implement testCreaRecensione().
     */
    public function testCreaRecensione() {
       $valore =  $this->object->creaRecensione("A.GIACOIA@HOTMAIL.IT", "Soddifacente", "Alex", "Sito molto carino e servizio a domicilio ottimo. Provate per credere.", 4);
       $this->assertEquals(null, $valore);
    }

}
