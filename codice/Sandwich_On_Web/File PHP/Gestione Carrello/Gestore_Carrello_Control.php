<?php
	require_once __DIR__ . "/../connect_db.php";
	require_once ("Menu_scelto.php");
	require_once("Carrello.php");
	require_once __DIR__ . "/../Gestione Menu/Componente.php";
	
    /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di un carrello.
    * @see Carrello
    * @see Componente
    * @see Menu_Scelto 
    */
        
	class Gestore_Carrello_Control
	{
        /**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_Carrello_Control
        */
        function __construct() 
        {
                
        }
		/**
                 * Metodo che elimina un menù scelto dal db.
                 * @param type $id_menu iddentificativo del menù scelto da eliminare.
                 * @return type null Ritorna un valore null se l'eliminazione è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function eliminaMenù ($id_menu)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			
			$query = "DELETE FROM menù_scelto WHERE ID_MENÙ_SCELTO = $id_menu"; 
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);
		}
		
                /**
                 * Metodo che elimina più menù scelti.
                 * @param array $menu_codici identificativi dei menù scelti. 
                 */
		function svuotaCarrello($menu_codici)
		{
			for($i=0; $i<count($menu_codici); $i++)
			{
				$this->eliminaMenù($menu_codici[$i]);
			}
		}
		
                /**
                 * Metodo che fa l'eco dei menù scelti di un utente contenuti nel carrello.
                 * @param type $email email univoca dell'utente.
                 */
		function creaVisualizzaCarrelloLista($email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from menù_scelto m where exists (select * from Contiene con where con.ID_MENÙ_SCELTO  = m.ID_MENÙ_SCELTO and con.ID_CARRELLO = (select c.ID_CARRELLO from CARRELLO c where c.ID_ACCOUNT = (select a.ID_ACCOUNT from account a where a.email = '$email')));";
			$risultato = mysql_query($query);
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$menu_scelto = new menu_scelto($riga['ID_MENÙ_SCELTO'], $riga['NOME'], $riga['PREZZO'], $riga['QUANTITÀ']);
				echo $menu_scelto . "-";
			} 
			
			mysql_free_result($risultato); 
			mysql_close($connessione);
		}
		
                /**
                 * Metodo che ritorna i dati di un carrello di un utente.
                 * @param type $email email univoca dell'utente.
                 */
		function getCarrello($email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query_id_carrello = "select car.ID_CARRELLO from carrello car where car.ID_ACCOUNT= (select acc.ID_ACCOUNT from Account acc where acc.email = '$email');";
			$risultato_carrello = mysql_query($query_id_carrello);
			$id_carrello = mysql_result($risultato_carrello, 0);
			
			$query = "select * from Carrello where ID_CARRELLO = '$id_carrello';";
			$risultato = mysql_query($query);
			while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
				$carrello = new carrello($riga['TOTALE_PREZZO'], $riga['TOTALE_QUANTITÀ']);
				return $carrello;
			} 
			
			mysql_free_result($risultato); 
			mysql_close($connessione);
			
		}
		
                /**
                 * Metodo che associa una componente ad un menù scelto.
                 * @param type $id_menu_scelto identificativo del menù scelto
                 * @param type $componente nome della componente.
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function creaCompostoDa($id_menu_scelto, $componente)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			
			$query_id_componente = "select c.id_componente from componente c where c.nome = '$componente';";
			$risultato_componente = mysql_query($query_id_componente);
			$id_componente = mysql_result($risultato_componente, 0);

			$query = "INSERT INTO Composto_da(ID_MENÙ_SCELTO, ID_COMPONENTE) VALUES($id_menu_scelto, $id_componente);";
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che inserisce un menù scelto nel db.
                 * @param type $nome nome del menù scelto
                 * @param type $prezzo prezzo associato al menù scelto
                 * @param type $quantita quantità associato al menù scelto
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function creaMenuScelto($nome, $prezzo, $quantita)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "INSERT INTO Menù_scelto(NOME, PREZZO, QUANTITÀ) VALUES ('$nome', '$prezzo', '$quantita');";
			if (mysql_query($query)) 
			{
				return  mysql_insert_id();
			}
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che aggiunge un menù scelto nel carrello di un utente.
                 * @param type $id_menu_scelto identificativo del menù scelto
                 * @param type $email email univoca del'utente
                 * @return type null Ritorna un valore null se l'inserimento è andato a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function aggiungiAlCarrello($id_menu_scelto, $email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query_id_carrello = "select car.ID_CARRELLO from carrello car where car.ID_ACCOUNT= (select acc.ID_ACCOUNT from Account acc where acc.email = '$email');";
			//$query_id_menu_scelto = "select m.ID_MENÙ_SCELTO from menù_scelto m where m.nome = '$menu_scelto';";
			$risultato_carrello = mysql_query($query_id_carrello);
			//$risultato_menu = mysql_query($query_id_menu_scelto);
			$id_carrello = mysql_result($risultato_carrello, 0);
			//$id_menu = mysql_result($risultato_menu, 0);
			$query = "INSERT INTO Contiene(ID_CARRELLO, ID_MENÙ_SCELTO) VALUES ($id_carrello, $id_menu_scelto);";
			if (mysql_query($query)) 
				return null;
			 else 
			 {
				 $errore = mysql_error();
				 	$query_delete = "DELETE FROM menù_scelto WHERE ID_MENÙ_SCELTO = '$id_menu_scelto' "; 
					if (! mysql_query($query_delete)) 
						return "Error: " . mysql_error();
			
				return "Error: " . $errore;
			 }
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che fa l'eco delle componenti associate a un menù scelto.
                 * @param type $id_menu identificativo del menù scelto
                 */
		function dettagliMenù($id_menu)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 

					
			$query_componenti = "select * from componente c where exists (select * from Composto_da cd where cd.ID_MENÙ_SCELTO = '$id_menu' and c.ID_COMPONENTE = cd.ID_COMPONENTE);";
			$risultato_componenti = mysql_query($query_componenti);
					while ($riga_com = mysql_fetch_assoc($risultato_componenti)) 
					{
						$componente = new componente($riga_com['NOME'], $riga_com['TIPO'], $riga_com['DESCRIZIONE'], $riga_com['PREZZO']);
						echo $componente . "-";
					}
					
			mysql_free_result($risultato_componenti);  
			
			mysql_close($connessione);
		}
	}
?>