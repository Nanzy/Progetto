<?php
	require_once __DIR__ . "/../Gestione Menu/Menu.php";
	require_once __DIR__ . "/../connect_db.php";
	
	     /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di un menù tra i preferiti.
    * @see Menu
    */
	class Gestore_QuickMenu_Control
	{
		/**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_QuickMenu_Control
        */
        function __construct() 
        {
                
        }
		/**
                 * Metodo che fa l'eco dei menù associati ai preferiti di un utente.
                 * @param type $email email univoca dell'utente
                 */
		function creaListaQuckMenù ($email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from Menù m where exists (select * from Aggiunge_A_Quick q where q.ID_ACCOUNT = (select id_account from account a where a.email='$email') AND  m.ID_MENÙ=q.ID_MENÙ);";
			$risultato = mysql_query($query);
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$menu_scelto = new menu($riga['NOME'], $riga['PREZZO'], $riga['DISPONIBILITA']);
				echo $menu_scelto . "-";
			} 
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
		
                /**
                 * Metodo che elimina un menù dai preferiti di un utente
                 * @param type $nome_menu nome del menù
                 * @param type $email email univoca dell'utente
                 * @return type null Ritorna un valore null se l'eliminazione è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function eliminaQuickMenù($nome_menu, $email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query = "DELETE FROM Aggiunge_a_Quick where ID_MENÙ = (select m.ID_MENÙ from Menù m where m.NOME='$nome_menu') and ID_ACCOUNT =  (select a.ID_ACCOUNT from Account a where a.email='$email');";

			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);
		}
	}
?>