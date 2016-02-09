<?php
	require_once("Menu.php");
	require_once("Componente.php");
	require_once __DIR__ . "/../connect_db.php";
        
          /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di un menù.
    * @see Menu 
    * @see Componente 
    */
	class Gestore_Menu_Control
	{
        /**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_Account_Control
        */
        function __construct() 
        {
                
        }
		/**
                 * Metodo che fa l'eco dei menù presenti nel db.
                 */
		function creaListaMenùForm()
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from menù;";
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
                 * Metodo che fa l'eco delle componenti associate ad un menù
                 * @param type $nome_menu nome del menù
                 */
		function creaSelezioneComponentiMenùForm ($nome_menu)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from componente c where exists (select * from Costituito_da com where com.id_menù=(select M.ID_MENÙ from Menù m where m.NOME='$nome_menu') and com.ID_COMPONENTE=c.ID_COMPONENTE);";
			$risultato = mysql_query($query);
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$componente = new componente($riga['NOME'], $riga['TIPO'], $riga['DESCRIZIONE'], $riga['PREZZO']);
				echo $componente . "-";
			} 
			
			
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
                
                /**
                 * Metodo che aggiunge un menù tra i preferiti dell'utente.
                 * @param type $nome_menu nome del menù
                 * @param type $email email univoca dell'utente
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function aggiungiAQuickMenù($nome_menu, $email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "INSERT INTO Aggiunge_a_Quick(ID_MENÙ, ID_ACCOUNT) VALUES((select m.ID_MENÙ from Menù m where m.Nome='$nome_menu') , (select a.ID_ACCOUNT from Account a where a.email='$email'));";

			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
	}
?>