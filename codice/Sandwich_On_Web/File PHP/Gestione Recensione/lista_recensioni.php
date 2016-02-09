<?php
	require_once("Gestore_Recensione_Control.php");
	$gestore = new Gestore_Recensione_Control();
	$recensione = $gestore->creaVisualizzaRecensioneLista();
	echo $recensione;
?>