<?php
	require_once("Gestore_Ordine_Control.php");
	$gestore = new Gestore_Ordine_Control();
	$id_ordine = $_GET['ordine'];
	$componente = $gestore->dettagliOrdine($id_ordine);
	echo $componente;
	
			
			
			
	
?>