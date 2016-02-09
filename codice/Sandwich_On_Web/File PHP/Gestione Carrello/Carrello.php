<?php 
     /**
     * Questa classe rappresenta un'atrazione di un carello.
     */
	class Carrello
	{
		
		private $_totale_prezzo;
		private $_totale_quantità;
	
		
		/**
                 * Metodo costruttore per instanziare un oggetto di tipo Carrello
                 * @param type $totale_prezzo totale prezzo del carrello
                 * @param type $totale_quantità totale quantità carrello
                 */
		function __construct($totale_prezzo, $totale_quantità) 
		{
			$this->_totale_prezzo = $totale_prezzo;
			$this->_totale_quantità = $totale_quantità;
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
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Carrello in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
			return $this->_totale_prezzo . '  ' . $this->_totale_quantità ;
		}
		
	}
?>
