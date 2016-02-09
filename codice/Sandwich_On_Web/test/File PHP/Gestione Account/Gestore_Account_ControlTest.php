<?php
require_once '../File PHP/Gestione Account/Gestore_Account_Control.php';
/**
 * Classe Test in riferimento alla classe Gestore_Account_Control
 * @see Gestore_Account_Control
 * @see Account
 */
class Gestore_Account_ControlTest extends PHPUnit_Framework_TestCase {

    /**
     * Riferimento globale all'oggetto di tipo Gestore_Account_Control
     * @var Gestore_Account_Control
     */
    protected $object;
    /**
     * Riferimento globale all'oggetto di tipo Account
     * @var Account
     */
    protected $account;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Gestore_Account_Control();
        $this->account = new Account(null , null, null, null, null, null, null, null, null); 
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
        unset($this->account);
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
     * @covers Gestore_Account_Control::creaAccount
     * @todo   Implement testCreaAccount().
     */
    public function testCreaAccount() {
        $valore = $this->object->creaAccount("Antonio", "Labanca", "A.LABANCA@HOTMAIL.IT", "ANTONIO", "SALERNO", "VIA ROMA 14", 85040, "3285967541");
        $this->assertEquals(null, $valore);
    }
    
    /**
     * @covers Gestore_Account_Control::accediAccount
     * @todo   Implement testAccediAccount().
     */
    public function testAccediAccount() {
       $this->testCreaAccount();
       $this->account =  $this->object->accediAccount("A.LABANCA@HOTMAIL.IT", "ANTONIO", "Utente");
       $this->assertEquals("Antonio", $this->account->_nome);
       
    }

    /**
     * @covers Gestore_Account_Control::creaCarrello
     * @todo   Implement testCreaCarrello().
     */
    public function testCreaCarrello() {
       $this->testAccediAccount();
       $this->object->creaCarrello("A.LABANCA@HOTMAIL.IT");
    }
    
    /**
     * @covers Gestore_Account_Control::modificaAccount
     * @todo   Implement testModificaAccount().
     */
    public function testModificaAccount() {
        $this->testAccediAccount();
        $value = $this->object->modificaAccount("A.LABANCA@HOTMAIL.IT", "ANTONIO", "FISCIANO", "VIA ROMA 14", 85040, "3285967541");
        $this->assertEquals(null, $value);
        $this->account = $this->object->accediAccount("A.LABANCA@HOTMAIL.IT", "ANTONIO", "Utente");
        $this->assertEquals("FISCIANO", $this->account->_citta);
        
    }

}
