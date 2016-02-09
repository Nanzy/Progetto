<?php 
    /**
     * Questa classe rappresenta un'atrazione di un ordine.
     * @author Egidio Giacoia
     */
	class Ordine
	{
		private $_id;
		private $_nome_utente;
		private $_tempo_attesa;
		private $_stato;
		private $_indirizzo_consegna;
		private $_orario_consegna;
		private $_totale_quantita;
		private $_totale_prezzo;
		
	
		
		/**
                 * Metodo costruttore per instanziare un oggetto di tipo Ordine.
                 * @param type $id identificativo dell'ordine
                 * @param type $nome_utente nome dell'utente
                 * @param type $tempo_attesa tempo di attessa specificato per la consegna dell'ordine
                 * @param type $stato stato dell'ordine
                 * @param type $indirizzo_consegna indirizzo di consegna dell'ordine
                 * @param type $orario_consegna orario di consegna desiderato dall'utente
                 * @param type $totale_quantita quantità totale dell'ordine
                 * @param type $totale_prezzo prezzo totale dell'ordine
                 */
		function __construct($id, $nome_utente, $tempo_attesa, $stato, $indirizzo_consegna, $orario_consegna, $totale_quantita, $totale_prezzo) 
		{
			$this->_id = $id;
			$this->_nome_utente = $nome_utente;
			$this->_tempo_attesa = $tempo_attesa;
			$this->_stato = $stato;
			$this->_indirizzo_consegna = $indirizzo_consegna;
			$this->_orario_consegna = $orario_consegna;
			$this->_totale_quantita = $totale_quantita;
			$this->_totale_prezzo = $totale_prezzo;
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
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Ordine in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
                    return   $this->_id . '  ' . $this->_nome_utente . '  ' . $this->_tempo_attesa . '  ' . $this->_stato . '  ' . $this->_indirizzo_consegna . '  ' . $this->_orario_consegna . '  ' . $this->_totale_quantita . '  ' . $this->_totale_prezzo;
		}
		
	}
?>
