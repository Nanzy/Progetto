<?php
	require_once("Ordine.php");
	require_once __DIR__ . "/../connect_db.php";
	require_once __DIR__ . "/../Gestione Carrello/Menu_scelto.php";
	require_once __DIR__ . "/../Gestione Menu/Componente.php";
	
          /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di un ordine.
    * @see Ordine
    * @see Componente
    * @see Menu_scelto 
    */
	class Gestore_Ordine_Control
	{
        /**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_Ordine_Control
        */
        function __construct() 
        {
                
        }
		
                /**
                 * Metodo che cancella un ordine nel db.
                 * @param type $id_ordine identificativo dell'ordine
                 * @param type $stato stato dell'ordine
                 * @return type null Ritorna un valore null se l' eliminazione è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function cancellaOrdine($id_ordine, $stato)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			
			if(strtoupper($stato) == "ATTESA")
			{
					$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
					mysql_select_db("sandwich_on_web"); 
					$query_possiede = "DELETE FROM possiede WHERE id_ordine = '$id_ordine';"; 
					if(! mysql_query($query_possiede)) 
						return "Error: " . mysql_error();
			}
			
			$query = "DELETE FROM ordine WHERE ID_ORDINE='$id_ordine';"; 
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);
		}
		
                /**
                 * Metodo che fa l'eco degli ordini associati ad un utente.
                 * @param type $email email univoca dell'utente
                 */
		function creaVisualizzaOrdiniLista ($email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from ordine o where o.id_account_utente = (select id_Account from Account a where a.EMAIL = '$email');";
			$risultato = mysql_query($query);
			
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				 
				$ordine = new ordine($riga['ID_ORDINE'], $riga['NOME_UTENTE'], $riga['TEMPO_ATTESA'], $riga['STATO'], $riga['INDIRIZZO_CONSEGNA'], $riga['ORARIO_CONSEGNA'], $riga['TOTALE_QUANTITÀ'], $riga['TOTALE_PREZZO']);
				echo $ordine . "-";
			} 
			
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
                    
                /**
                 * Metodo che associa un menù scelto ad un ordine.
                 * @param type $id_ordine identificativo dell'ordine
                 * @param type $id_menu identificativo del menù scelto
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function creaPossiede($id_ordine, $id_menu)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			
			$query = "INSERT INTO Possiede(ID_ORDINE, ID_MENÙ_SCELTO) VALUES ('$id_ordine', '$id_menu');";
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che crea un ordine nel db
                 * @param type $email email univoca dell'utente
                 * @param type $nome nome dell'utente
                 * @param type $indirizzo indirizzo della consegna dell'ordine
                 * @param type $orario orario desiderato dall'utente
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function checkOut($email, $nome, $indirizzo, $orario)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
			$query_id = "SELECT ID_ACCOUNT FROM ACCOUNT WHERE EMAIL = '$email';";
			$risultato_id = mysql_query($query_id);
			$id_account = mysql_result($risultato_id, 0);
			$query = "INSERT INTO Ordine( NOME_UTENTE, STATO, INDIRIZZO_CONSEGNA, ORARIO_CONSEGNA, ID_ACCOUNT_UTENTE, TOTALE_QUANTITÀ, TOTALE_PREZZO) VALUES ('$nome', 'ATTESA', '$indirizzo', '$orario', '$id_account' , 0, 0);";
			if (mysql_query($query)) 
				return  mysql_insert_id();
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che fa l'eco dei menù scelti e delle componenti  associato ad un ordine.
                 * @param type $id_ordine identificativo dell'ordine
                 */
		function dettagliOrdine($id_ordine)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD );  
			mysql_select_db("sandwich_on_web"); 
	
			$query = "select p.ID_MENÙ_SCELTO from Possiede p where p.ID_ORDINE = $id_ordine;";
			$risultato = mysql_query($query);
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$id_menu = $riga['ID_MENÙ_SCELTO'];
				
				$query_menù_scelto = "select * from menù_scelto m where m.ID_MENÙ_SCELTO = '$id_menu'";
				$risultato_menu = mysql_query($query_menù_scelto);
					$riga_menu = mysql_fetch_assoc($risultato_menu);
					$menu_scelto = new menu_scelto($riga_menu['ID_MENÙ_SCELTO'],$riga_menu['NOME'], $riga_menu['PREZZO'], $riga_menu['QUANTITÀ']);
					echo $menu_scelto . "<br>";
					
					mysql_free_result($risultato_menu); 
					
					$query_componenti = "select * from componente c where exists (select * from Composto_da cd where cd.ID_MENÙ_SCELTO = '$id_menu' and c.ID_COMPONENTE = cd.ID_COMPONENTE);";
					$risultato_componenti = mysql_query($query_componenti);
					while ($riga_com = mysql_fetch_assoc($risultato_componenti)) 
					{
						$componente = new componente($riga_com['NOME'], $riga_com['TIPO'], $riga_com['DESCRIZIONE'], $riga_com['PREZZO']);
						echo $componente . "<br>";
					}
					
					mysql_free_result($risultato_componenti);  
				
				
				echo "-";
			
			}
				
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
	}
?>