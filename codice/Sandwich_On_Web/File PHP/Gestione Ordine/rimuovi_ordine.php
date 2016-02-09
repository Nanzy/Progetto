<?php
	require_once("Gestore_Ordine_Control.php");
	$gestore = new Gestore_Ordine_Control();
	$id_ordine = $_GET['ordine'];
	$stato = $_GET['stato'];
	
	$risultato = $gestore->cancellaOrdine($id_ordine, $stato);

	echo $risultato;
?>