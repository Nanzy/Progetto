<?php
	require_once("Account.php");	
	require_once __DIR__ . "/../connect_db.php";
	
    /**
    * Questa classe gestisce le interazioni tra utente e sistema, eseguendo query al database.
    * Si occupa della gestione di un account.
    * @see Account 
    */
	class Gestore_Account_Control
	{
            
        /**
        * Metodo costruttore per instanziare un oggetto di tipo Gestore_Account_Control
        */
        function __construct() 
        {
                
        }

        /**
        * Metodo che effettua il logout di un utente autenticato.
        */
        function disconnetti()
        {
            setcookie("Account_Accesso", "",  time() - 3600);
        }
		
        /**
        * Metodo che effettua il login.
        * Verifica che un utente sia registrato nel sistema.
        * @param type email email univoca dell'utente.
        * @param type password password associata all'email dell'utente.
        * @param type type tipo di account con cui si vuole effettuare l'accesso.
        * @return Account Ritorna l'account associato ai parametri inseriti se presenti nel db.
        * @return null Ritorna un valore null se il db non contiene un account associato con tali parametri.
        */     
        function accediAccount($email, $password, $type)
        {
            $connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "select * from account"; 
			$risultato = mysql_query($query);
            while ($riga = mysql_fetch_assoc($risultato)) 
			{ 
                if($type == "Utente")
                {
					if(trim($email) == $riga['EMAIL'] && trim($password) == $riga['PASS'] && $riga['TIPO'] == "UTENTE")
					{ 
                        $account_utente = new account($riga['NOME'], $riga['COGNOME'], $riga['EMAIL'], $riga['PASS'], $riga['CITTÁ'], $riga['INDIRIZZO'], $riga['CAP'], $riga['N_TELEFONO'], $riga['TIPO']); 
							
                        return $account_utente;
					}
                }
				
                if($type == "Amministratore")
                {
					if(trim($email) == $riga['EMAIL'] && trim($password) == $riga["PASS"] && ("GESTORE DEI MENÙ" == $riga["TIPO"] || 
					"GESTORE DEGLI ORDINI" == $riga["TIPO"] || "FATTORINO" == $riga["TIPO"])) 
                    {
						$account_utente = new account($riga['NOME'], $riga['COGNOME'], $riga['EMAIL'], $riga['PASS'], $riga['CITTÁ'], $riga['INDIRIZZO'], $riga['CAP'], $riga['N_TELEFONO'], $riga['TIPO']); 
						
                        return $account_utente;
                    }
				}
			} 
			mysql_free_result($risultato); 
			mysql_close($connessione);
			return null;
        }		
		
		/**
        * Metodo che crea un account registrandolo nel sistema.
        * @param type $nome nome dell'utente.
        * @param type $cognome cognome dell'utente.
        * @param type $email email univoca dell'utente.
        * @param type $pass password dell'utente.
        * @param type $citta città dell'utente.
        * @param type $indirizzo  indirizzo dell'utente.
        * @param type $cap cap associato alla città dell'utente.
        * @param type $telefono dell'utente.
        * @return type null Ritorna un valore null se l'inserimento è andata a buon fine.
        * @return string Ritorna una stringa contenente la causa di errore.
         */
		function creaAccount($nome, $cognome, $email, $pass, $citta, $indirizzo, $cap, $telefono)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "INSERT INTO Account(NOME, COGNOME, EMAIL, PASS, CITTÁ, INDIRIZZO, CAP, N_TELEFONO,TIPO) VALUES ('$nome', '$cognome', '$email', '$pass', '$citta', '$indirizzo', '$cap', '$telefono', 'UTENTE');";

			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);		
		}
		
                /**
                 * Metodo che associa un carrello ad un utente.
                 * @param type $email email univoca dell'utente.
                 * @return type null Ritorna un valore null se l'inserimento è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function creaCarrello($email)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query_id = "SELECT ID_ACCOUNT FROM ACCOUNT WHERE EMAIL = '$email';";
			$risultato_id = mysql_query($query_id);
			$id_account = mysql_result($risultato_id, 0);
			$query = "INSERT INTO CARRELLO(ID_ACCOUNT) VALUES($id_account);";
			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
		}
		
                /**
                 * Metodo che modifica i dati di un account registrato nel sistema.
                 * @param type $email email dell'utente
                 * @param type $password password associata all'utente
                 * @param type $citta città dell'utente
                 * @param type $indirizzo indirizzo dell'utente
                 * @param type $cap cap associtao alla città dell'utente
                 * @param type $telefono telefono dell'utente
                 * @return type null Ritorna un valore null se la modifica è andata a buon fine.
                 * @return sring Ritorna una stringa contenente la causa di errore.
                 */
		function modificaAccount($email, $password, $citta, $indirizzo, $cap, $telefono)
		{
			$connessione =  mysql_connect(connection::$SERVER, connection::$USERNAME, connection::$PASSWORD ); 
			mysql_select_db("sandwich_on_web"); 
			$query = "UPDATE Account SET PASS = '$password', CITTÁ = '$citta',INDIRIZZO = '$indirizzo', CAP= '$cap' , N_TELEFONO = '$telefono' WHERE EMAIL = '$email';";

			if (mysql_query($query)) 
				return null;
			 else 
				return "Error: " . mysql_error();
			
			mysql_close($connessione);	
			disconnetti();
		}			
	}
?>