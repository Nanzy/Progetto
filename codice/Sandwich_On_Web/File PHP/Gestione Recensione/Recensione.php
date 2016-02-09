<?php 
    /**
     * Questa classe rappresenta un'atrazione di una recensione.
     */
	class Recensione
	{
		
		private $_titolo;
		private $_testo;
		private $_nickname;
		private $_apprezzamento;
		
		
		/**
                 * Metodo costruttore per instanziare un oggetto di tipo Recensione
                 * @param type $titolo titolo della recensione
                 * @param type $testo contenuto della recensione
                 * @param type $nickname nickname di chi ha scritto la recensione
                 * @param type $apprezzamento giudizio del servizio offerto.
                 */
		function __construct($titolo, $testo, $nickname, $apprezzamento) 
		{
			$this->_titolo = $titolo;
			$this->_testo = $testo;
			$this->_nickname = $nickname;
			$this->_apprezzamento = $apprezzamento;
		}
		
		  /**
                 * Metodo che ritorna il valore di un determinato proprietà.
                 * @param type $property nome proprietà
                 * @return type valore della proprietà
                 */
		public function __get($property) 
		{
			if (property_exists($this, $property)) 
				return $this->$property;
		}

		/**
                * Metodo che cambia il valore di un determinata proprietà, ritornando il valore precedente di essa.
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
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Recensione in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
			return $this->_titolo . '/' . $this->_testo . '/' . $this->_nickname . '/' . $this->_apprezzamento;
		}
		
	}
?>
