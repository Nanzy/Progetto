<?php 
    /**
     * Questa classe rappresenta un'atrazione di una componente.
     */
	class Componente
	{
		
		private $_nome;
		private $_tipo;
		private $_descrizione;
		private $_prezzo;
	
		
		/**
                 * Metodo costruttore per instanziare un oggetto di tipo Componente.
                 * @param type $nome nome della componente
                 * @param type $tipo tipo della componente
                 * @param type $descrizione descrizione della componente
                 * @param type $prezzo prezzo associato alla componente
                 */
		function __construct($nome, $tipo, $descrizione, $prezzo) 
		{
			$this->_nome = $nome;
			$this->_tipo = $tipo;
			$this->_descrizione = $descrizione;
			$this->_prezzo = $prezzo;
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
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Componente in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
			return $this->_nome . ' / ' . $this->_tipo . ' / ' . $this->_descrizione . ' / ' . $this->_prezzo;
		}
		
	}
?>
