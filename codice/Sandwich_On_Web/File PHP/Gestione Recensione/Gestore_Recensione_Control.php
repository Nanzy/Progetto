<?php
	require_once("Recensione.php");
	require_once __DIR__ . "/../connect_db.php";
	
	     /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di una recensione.
    * @see Recensione
    */
	class Gestore_Recensione_Control
	{
	/**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_Recensione_Control
        */
        function __construct() 
        {
                
        }
		/**
                 * Metodo che fa l'eco delle recensioni presenti nel db.
                 */
		function creaVisualizzaRecensioneLista ()
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from recensione;";
			$risultato = mysql_query($query);
			
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$recensione = new recensione($riga['TITOLO'], $riga['TESTO'], $riga['NICKNAME'], $riga['APPREZZAMENTO']);
				echo $recensione . "-";
			} 
			
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
		
            	/**
                 * Metodo che inserisce una recensione nel db.
                 * @param type $email email univoca dell'utente
                 * @param type $titolo titolo della recensione.
                 * @param type $nickname nickname da utilizzare per la recensione.
                 * @param type $testo contenuto della recensione
                 * @param type $valutazione valutazione della recensione.
                 * @return type null Ritorna un valore null se la modifica è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function creaRecensione($email, $titolo, $nickname, $testo, $valutazione)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query_id = "select a.id_account from Account a where a.email = '$email'";
			$risultato = mysql_query($query_id);
			$id = mysql_result($risultato, 0);
			$query = "INSERT INTO Recensione(TITOLO, TESTO, NICKNAME, APPREZZAMENTO, ID_ACCOUNT) VALUES ('$titolo', '$testo','$nickname', '$valutazione', '$id');";
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
	
	}
?>