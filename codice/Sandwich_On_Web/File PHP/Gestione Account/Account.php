<?php 
    /**
     * Questa classe rappresenta un'astrazione di un account.
     */
	class Account
	{      
		private $_nome;
		private $_cognome;
		private $_email;
		private $_pass;
		private $_citta;
		private $_indirizzo;
		private $_cap;
		private $_telefono;
		private $_tipo;
		
                /**
                 * Metodo costruttore per instanziare un oggetto di tipo Account
                 * @param type $nome nome dell'utente.
                 * @param type $cognome cognome dell'utente.
                 * @param type $email email univoca dell'utente.
                 * @param type $pass password dell'utente.
                 * @param type $citta città dell'utente.
                 * @param type $indirizzo  indirizzo dell'utente.
                 * @param type $cap cap associato alla città dell'utente.
                 * @param type $telefono telefono dell'utente
                 * @param type $tipo tipo di utente.
                 */
		function __construct($nome, $cognome,  $email, $pass, $citta, $indirizzo, $cap, $telefono, $tipo) 
		{
			$this->_nome = $nome;
			$this->_cognome = $cognome;
			$this->_email = $email;
			$this->_pass = $pass;
			$this->_citta = $citta;
			$this->_indirizzo = $indirizzo;
			$this->_cap = $cap;
			$this->_telefono = $telefono;
			$this->_tipo = $tipo;
		}
		
                /**
                 * Metodo che ritorna il valore di una determinata proprietà.
                 * @param type $property nome proprietà
                 * @return type valore della proprietà
                 */
		public function __get($property) 
		{
			if (property_exists($this, $property)) 
				return $this->$property;
		}

               /**
                * Metodo che cambia il valore di una determinata proprietà, ritornando il valore precedente di essa.
                * @param type $property nome della proprietà da cambiare
                * @param type $value nuovo valore della proprità
                * @return type valore precedente della proprietà
                */
		public function __set($property, $value) 
		{
                        $old_property = $this->$property;
			if (property_exists($this, $property)) 
				$this->$property = $value;
			return $old_property;
		}
		
                /**
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Account in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
			return $this->_nome . '  ' . $this->_cognome . '  ' . $this->_email . '  ' . $this->_pass . '  ' . $this->_citta . '  ' . $this->_indirizzo . '  ' . $this->_cap . '  ' . $this->_telefono . '  ' . $this->_tipo;
		}
		
	}
?>
