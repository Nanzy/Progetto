<?php 
    /**
     * Questa classe rappresenta un'atrazione di un menù che è stato scelto.
     */
	class Menu_Scelto
	{
		private $_id;
		private $_nome;
		private $_prezzo;
		private $_quantità;
		
		/**
                 * Metodo costruttore per instanziare un oggetto di tipo Menu_Scelto
                 * @param type $id identificativo del menù scelto
                 * @param type $nome nome del menù scelto
                 * @param type $prezzo prezzo del menù scelto
                 * @param type $quantità quantità del menù scelto
                 */
		function __construct($id, $nome, $prezzo, $quantità) 
		{
			$this->_id = $id;
			$this->_nome = $nome;
			$this->_prezzo = $prezzo;
			$this->_quantità = $quantità;
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
                 * Metodo che ritorna il valore di tutte le proprietà dell'oggetto Menu_Scelto in un formato stabilito.
                 * @return string ritorna il valore di tutte le proprietà dell'oggetto 
                 */
		public function __toString() 
		{
			return $this->_nome . '  ' . $this->_prezzo . '  ' . $this->_quantità . '  '.$this->_id;
		}
		
	}
?>