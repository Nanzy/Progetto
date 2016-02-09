<?php
require_once '../File PHP/Gestione Menu/Gestore_Menu_Control.php';
/**
 * Classe Test in riferimento alla classe Gestore_Account_Control
 * @see Gestore_Menu_Control
 * @see Menu
 */
class Gestore_Menu_ControlTest extends PHPUnit_Framework_TestCase {

    /**
     * Riferimento globale all'oggetto di tipo Gestore_Menu_Control
     * @var Gestore_Menu_Control
     */
    protected $object;
    /**
     * Riferimento globale all'oggetto di tipo Menu
     * @var Menu
     */
    protected $menu;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Gestore_Menu_Control();
        $this->menu = new Menu(null, null , null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
        unset($this->menu);
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
     * @covers Gestore_Menu_Control::creaListaMenùForm
     * @todo   Implement testCreaListaMenùForm().
     */
    public function testCreaListaMenùForm() {
       echo $this->object->creaListaMenùForm();
    }

    /**
     * @covers Gestore_Menu_Control::creaSelezioneComponentiMenùForm
     * @todo   Implement testCreaSelezioneComponentiMenùForm().
     */
    public function testCreaSelezioneComponentiMenùForm() {
        echo  $this->object->creaSelezioneComponentiMenùForm("Classico");
    }

    /**
     * @covers Gestore_Menu_Control::aggiungiAQuickMenù
     * @todo   Implement testAggiungiAQuickMenù().
     */
    public function testAggiungiAQuickMenù() {
      $valore =  $this->object->aggiungiAQuickMenù("Classico", "A.GIACOIA@HOTMAIL.IT");
      $this->assertEquals(null, $valore);
    }

}
